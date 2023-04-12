//frmbtnsavePaymentSample
//frmbtnsavePaymentSample
$('#btnsavePaymentSample').click(function(){
  $('#frmbtnsavePaymentSample').ajaxSubmit();

});
//add_payment_sample
function add_payment_sample( rowid )
{
  //payItemSampleDiv
  var formData = {
    'recordID': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getSampleItemDetailPayment',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      console.log(res.HTML);

      $( '#payItemSampleDiv' ).html( res.HTML );
      $( '#payAmt' ).val( res.itemQTYAMT );
      $( '#sample_id_pay' ).val( rowid );
      $( '#m_modal_6_payment_add_sample' ).modal( 'show' );

    }
  });

  
}
//add_payment_sample

function add_feedback_sample( rowid )
{
  $( '#v_s_id' ).val( rowid );
  
  $( '#m_modal_6_feedback' ).modal( 'show' );
}
//add_feedback_sampleTech

var BootstrapSelect = { init: function () { $( ".m_selectpicker" ).selectpicker() } }; jQuery( document ).ready( function () { BootstrapSelect.init() } );



//wantToRejectorModifySample
function wantToRejectorModifySample( rowid )
{

  $( '#sampleIDARM' ).val( rowid );
  $( '#m_modal_6_sampleRejectModify' ).modal( 'show' );
}
//wantToRejectorModifySample


//view_technical_feedback
function view_technical_feedback( rowid )
{
  //ajax 
  var formData = {
    'recordID': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getSampleFeedbackData',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        var strREQ = "";
        var fileID = 7;
        var dataArr = res.data;
        if ( dataArr === "NULL" || dataArr === null )
        {
          strREQ = "";
        } else
        {
          fileID = parseInt( dataArr.sample_feedback );
          console.log( fileID );
        }



        switch ( fileID )
        {
          case 1:
            // code block
            var strREQ = "Changes suggest resend samples";
            break;
          case 2:
            // code block
            var strREQ = "Did not like";
            break;
          case 3:
            // code block
            var strREQ = "Stopped Responding";
            break;
          case 4:
            // code block
            var strREQ = "Sample Selected";
            break;
          case 5:
            // code block
            var strREQ = "Not Received Yet";
            break;

          // code block
        }


        // console.log( dataArr.sample_feedback_other );
        if ( dataArr === "NULL" || dataArr === null )
        {
          $( '.showfeedbackSample' ).html( `<div class="m-section">
        <h3 class="m-section__heading">Feeback Type :<b>${ strREQ }</b></h3>
        <span class="m-section__sub">
       
        </span>
       
      </div>`);
        } else
        {
          $( '.showfeedbackSample' ).html( `<div class="m-section">
        <h3 class="m-section__heading">Feeback Type :<b>${ strREQ }</b></h3>
        <span class="m-section__sub">
          <strong style="color:#035496"> ${ dataArr.sample_feedback_other }</strong>
        <br>
        <b>Feedback Added on : </b>
        ${ dataArr.feedback_addedon }
        </span>
       
      </div>`);
        }



        $( '#m_select2_modal_sampleTechFeedbackDoc' ).modal( 'show' );

      } else
      {

      }


    },
    dataType: "json"
  } );
  //ajax 


}

//view_technical_feedback

//add_technical_approval_with_price
function add_technical_approval_with_price( rowid )
{
  $( '#txtSampleID_approvalPrice' ).val( rowid );

  $( '#m_select2_modal_sampleTechApprovalPrice' ).modal( 'show' );
}
//add_technical_approval_with_price

//view_QuestionsFAQ
function view_QuestionsFAQ( rowid )
{


  // ajax
  var formData = {
    'recordID': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getFAQDetailsBYID',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '.showFAQQuestionDetails' ).html( "" );
      $( '.showFAQQuestionDetailsAns' ).html( "" );
      $( '#txtfaqID' ).val( rowid );
      $( '.showFAQQuestionDetails' ).append( res.Question );
      $( '.showFAQQuestionDetailsAns' ).append( res.QuestionAns );
      $( '#m_select2_modal_FAQ_detail' ).modal( 'show' );

    }
  } );
  // ajax





}

//view_QuestionsFAQ

//view_sample_tech_details
function view_sample_tech_details( rowid )
{


  // ajax
  var formData = {
    'recordID': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getAllSampleDetails',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '.showSampleAllDetails' ).html( res );
    }
  } );
  // ajax

  $( '#m_select2_modal_sampleTechDOC_viewDetail' ).modal( 'show' );



}
//view_sample_tech_details

//add_feedback_sampleTechFileOrder
function add_feedback_sampleTechFileOrder( rowid, fileID )
{

  switch ( fileID )
  {
    case 1:
      // code block
      var strREQ = "COA";
      break;
    case 2:
      // code block
      var strREQ = "MSDS";
      break;
    case 3:
      // code block
      var strREQ = "STABILITY";
      break;
    default:
    // code block
  }


  if ( fileID == 1 )
  {
    $( '.ingreInputdata' ).show();
  } else
  {
    $( '.ingreInputdata' ).hide();
  }

  $( '#txtSampleID_DOC' ).val( rowid );
  $( '.strREQ' ).html( strREQ );
  $( '#m_select2_modal_sampleTechDOC' ).modal( 'show' );

}

//add_feedback_sampleTechFile

//add_feedback_sampleTechFile
function add_feedback_sampleTechFile( rowid, fileID )
{

  switch ( fileID )
  {
    case 1:
      // code block
      var strREQ = "INGREDIENT";
      break;
    case 2:
      // code block
      var strREQ = "COA";
      break;
    case 3:
      // code block
      var strREQ = "MSDS";
      break;
    default:
    // code block
  }


  if ( fileID == 1 )
  {
    $( '.ingreInputdata' ).show();
  } else
  {
    $( '.ingreInputdata' ).hide();
  }

  $( '#txtSampleID_DOC' ).val( rowid );
  $( '.strREQ' ).html( strREQ );
  $( '#m_select2_modal_sampleTechDOC' ).modal( 'show' );

}
//add_feedback_sampleTechFile

function add_feedback_sampleTech( rowid )
{
  $( '#txtSampleID' ).val( rowid );
  $( '#m_select2_modal_sampleTech' ).modal( 'show' );
}
//add_feedback_sampleTech

function QC_orderStage( rowid, s_status )
{
  var formData = {
    'recordID': rowid,
    's_status': s_status,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setQCPurchaseStatus',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status )
      {
        toasterOptions();
        toastr.success( 'Updated Successfully ', 'Refresh Now' );
        return true;
      }
    }
  } );


}
function QC_orderStageProduction( rowid, s_status )
{
  alert( 'Please .Do update from order list and order stage now' );
  return false;

  var formData = {
    'recordID': rowid,
    's_status': s_status,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setQCProductionStatus',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status )
      {
        toasterOptions();
        toastr.success( 'Updated Successfully ', 'Refresh Now' );
        return true;
      }
    }
  } );


}

function sent_sample_AssingnTrackID( rowid )
{
  $( '#sampleIDATrackID' ).val( rowid );
  $( '#m_modal_6_assinedSampleToTID' ).modal( 'show' );
}
//sent_sample_Assingn
function sent_sample_Assingn( rowid )
{
  $( '#sampleIDA' ).val( rowid );
  $( '#m_modal_6_assinedSampleTo' ).modal( 'show' );

}
//sent_sample_Assingn
//set_samplePriority
function set_samplePriority( rowid )
{
  $( '#sampleIDAP' ).val( rowid );
  $( '#m_modal_6_assinedSampleTo89' ).modal( 'show' );
}
//set_samplePriority
//view_sampleFormulation
function view_sampleFormulation( rowid )
{
  //ajax
  $( '.ajsampleFormulaviewDetail' ).html( '' );

  var formData = {
    'recordID': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getSampleFormulaDetails',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '#model_sampleFormulaAppsViews' ).modal( 'show' );
      //ajsampleFormulaviewDetail
      $.each( res, function ( index, value )
      {
        $( '.ajsampleFormulaviewDetail' ).append( ` <table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
        <thead>
            <tr>
                <th colspan="6">Sample ID:<b>${ value.sample_code_with_part } </b> |Item Name:<b>${ value.item_name }</b> Created On:<b>${ value.formulated_on } </b></th>

            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row"><b>Key Ingredent:</b><br>${ value.key_ingredent }</th>
                <td><b>Fragrance:</b><br>${ value.fragrance }</td>
                <td><b>Color:</b><br>${ value.color_val }</td>
                <td><b>PH:</b><br>${ value.ph_val }</td>
                <td><b>Apperance:</b><br>${ value.apperance_val }</td>
                <td><b>Chemist:</b><br>${ value.chemist_id }</td>
            </tr>
        </tbody>
    </table>`);



        // console.log();
        // console.log(value.fragrance);
        // console.log(value.color_val);
        // console.log(value.ph_val);
        // console.log(value.apperance_val);
        // console.log(value.chemist_id);
        // console.log(value.created_on);
        // console.log(value.created_by);

      } )

      //ajsampleFormulaviewDetail
    },
    dataType: "json"
  } );
  //ajax 

}
//view_sampleFormulation

function sent_sample( rowid )
{
  $( '.ajrow_tr_new' ).hide();
  $( '.ajrow_tr_c' ).hide();
  var formData = {
    'recordID': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getSampleDetails',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      //$('#txtShowRejectdata').html("");


      if ( parseInt( res.sample_details.is_rejected ) == 1 )
      {

        $( '#txtShowRejectdata' ).html( `NOTE: <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">${ res.sample_details.is_rejected_msg }</span>` );
      }
      var ispaidStr = "";
      if ( parseInt( res.sample_details.is_paid ) == 1 )
      {
        ispaidStr = ` <a href="javascript::void(0)" class="btn btn-success btn-sm m-btn  m-btn m-btn--icon">
        <span>
          <i class="fa fa-rupee-sign"></i>
          <span>PAID SAMPLE</span>
        </span>
      </a>`;

      }


      //console.log(res.client_data.sample_code);
      $( '#status_sample  option[value="' + res.sample_details.status_id + '"]' ).prop( "selected", true );
      $( '#courier_data  option[value="' + res.sample_details.courier_id + '"]' ).prop( "selected", true );
      //v_s_id

      if ( res.sample_details.status_id != 2 )
      {
        $( '.ajrow_tr_new' ).show();

        if ( res.client_data.edit_pe == 0 )
        {
          $( '.ajrow_tr_new' ).hide();
        }

      } else
      {
        $( '.ajrow_tr_c' ).show();
      }
      var samples = JSON.parse( res.sample_details.sample_details );
      var i = 0;
      $( '#itemdata' ).html( " " );
      $.each( samples, function ( index, value )
      {
        i++;
        if ( value.sample_type == 1 )
        {
          var catTY = "COSMATIC";
        } else
        {
          var catTY = "OILS";
        }
        $( '#itemdata' ).append( `<tr>
        <th scope="row">${ i }</th>
        <td>${ value.sample_type }</td>
        <td>${ value.txtItem }</td>
        <td>${ value.txtDiscrption }</td>
        <td>${ value.price_per_kg }</td>
      </tr>`);


      } );


      $( '#s_status' ).html();
      $( '#v_s_id' ).val( res.client_data.s_id );
      $( '#s_id' ).html( res.client_data.sample_code + ispaidStr );
      $( '#s_company' ).html( res.client_data.company );

      $( '#s_contactName' ).html( res.client_data.contact_name );
      $( '#s_contactPhone' ).html( res.client_data.phone );

      $( '#s_ship_address' ).html( res.client_data.address );
      $( '#s_location' ).html( res.client_data.location );
      $( '#s_status' ).html( res.sample_details.status );
      $( '#s_courier_name' ).html( res.sample_details.courier_name );
      $( '#s_track_id' ).html( res.sample_details.track_id );
      $( '#s_sent_on' ).html( res.client_data.sent_on );
      $( '#s_remarks' ).html( res.sample_details.courier_remarks );


      $( '#view_sent_sample_form' ).modal( 'show' );
    },
    dataType: 'json'
  } );
}

function clearSampleView()
{
  $( '#v_name' ).html( '' );
  $( '#user_id' ).html( '' );
  $( '#v_email' ).html( '' );
  $( '#v_phone' ).html( '' );
  $( '#v_companay' ).html( '' );
  $( '#v_address' ).html( '' );
  $( '#gst_details' ).html( '' );
  $( '#brand_name' ).html( '' );
  $( '#remarks' ).html( '' );
  $( '#s_name' ).html( '' );
  $( '#s_email' ).html( '' );
  $( '#s_phone' ).html( '' );
  $( '#sid_code' ).html( '' );
  $( '#s_id' ).val( '' );
  $( '#sample_details' ).html( '' );
  $( '#courier_details' ).html( '' );
  $( '#v_track_id' ).html( '' );
  $( '#v_created_on' ).html( '' );
  $( '#v_status' ).html( '' );
  $( '#v_remarks' ).html( '' );
  $( '#v_feedback' ).html( '' );
  $( '#v_created_by' ).html( '' );
}
function m_view_sample_details_now( rowid )
{
  var formData = {
    'recordID': rowid
  };
  $.ajax( {
    url: BASE_URL + '/api/getSampleDetails',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.sample_details.status_id == 2 )
      {
        $( '.aj_sample_status' ).hide()
        $( '.aj_sample_status_new' ).show()
      } else
      {
        $( '.aj_sample_status' ).show()
        $( '.aj_sample_status_new' ).hide()
      }
      clearSampleView();
      $( '#v_name' ).html( res.client_data.contact_name );
      $( '#user_id' ).html( res.client_data.user_id );
      $( '#v_email' ).html( res.client_data.email );
      $( '#v_phone' ).html( res.client_data.phone );
      $( '#v_companay' ).html( res.client_data.company );
      $( '#v_address' ).html( res.client_data.address );
      $( '#gst_details' ).html( res.client_data.gst_details );
      $( '#brand_name' ).html( res.client_data.brand_name );
      $( '#remarks' ).html( res.client_data.remarks );
      $( '#s_name' ).html( res.agent_data.name );
      $( '#s_email' ).html( res.agent_data.email );
      $( '#s_phone' ).html( res.agent_data.phone );
      $( '#sid_code' ).html( res.client_data.sample_code );
      $( '#v_s_id' ).val( rowid );
      var sampleJSON = res.sample_details.sample_details;
      // console.log(sampleJSON);
      var HTML = '';
      var obj = JSON.parse( sampleJSON );
      var i = 0;
      $( obj ).each( function ( i, item )
      {
        i++;
        HTML += '<tr><th scope="row">' + i + '</th><td>' + item.txtItem + '</td><td>' + item.txtDiscrption + '</td></tr>';
      } )


      $( '#sample_details' ).html( `<table class="table table-sm m-table m-table--head-bg-primary">
													<thead class="thead-inverse">
														<tr>
															<th>#</th>
															<th>Item </th>
															<th>Descriptions</th>

														</tr>
													</thead>
													<tbody>
                          ${ HTML }

													</tbody>
												</table>
`);
      $( '#sent_on' ).html( res.client_data.sent_on );
      sent_on
      $( '#courier_details' ).html( res.sample_details.courier_details );
      $( '#v_track_id' ).html( res.sample_details.track_id );
      $( '#v_created_on' ).html( res.sample_details.created_at );
      $( '#v_status' ).html( res.sample_details.status );
      $( '#v_remarks' ).html( res.sample_details.remarks );
      $( '#v_feedback' ).html( res.sample_details.feedback );
      $( '#v_created_by' ).html( res.sample_details.created_by );
      $( '#m_view_sample_details' ).modal( 'show' );

    }
  } );

}
//sampleResubmit
function sampleResubmit( rowid )
{

  swal( {
    title: "Are you sure?",
    text: "You want to resubmit this!",
    type: "success",
    showCancelButton: !0,
    confirmButtonText: "Yes,submit",
    cancelButtonText: "No, Cancel!",
    reverseButtons: !1
  } ).then( function ( ey )
  {
    if ( ey.value )
    {
      $.ajax( {
        url: BASE_URL + "/sampleResubmit",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), s_id: rowid },
        success: function ( resp )
        {
          console.log( resp );
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
            swal( "Re- Submit!", "Your sample has been re-submitted.", "success" ).then( function ( eyz )
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

//sampleResubmit
//delete_sampleRNDFormulaBase
function delete_sampleRNDFormulaBase( rowid )
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
        url: BASE_URL + "/deleteSampleRNDFormulaBase",
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
                //location.reload();
              }
            } );
          } else
          {
            swal( "Deleted!", "Your sample Formula  has been deleted.", "success" ).then( function ( eyz )
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


//delete_sampleRNDFormulaBase
//delete_sampleRNDFormula
function delete_sampleRNDFormula( rowid )
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
        url: BASE_URL + "/deleteSampleRNDFormula",
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
                //location.reload();
              }
            } );
          } else
          {
            swal( "Deleted!", "Your sample Formula  has been deleted.", "success" ).then( function ( eyz )
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


//delete_sampleRNDFormula


function delete_sample( rowid )
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
        url: BASE_URL + "/deleteSample",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), s_id: rowid },
        success: function ( resp )
        {
          console.log( resp );
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

function edit_sample( rowid )
{
  var formData = {
    'recordID': rowid
  };
  $.ajax( {
    url: BASE_URL + '/api/getSampleDetails',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      console.log( res.client_data );
      $( '#edit_sample_id' ).val( res.sample_details.sample_id );
      $( '#m_select2_2  option[value="' + res.client_data.user_id + '"]' ).prop( "selected", true );
      $( '#edit_m_courier  option[value="' + res.sample_details.courier_id + '"]' ).prop( "selected", true );
      $( '#edit_statusdata  option[value="' + res.sample_details.status_id + '"]' ).prop( "selected", true );
      $( '#edit_sample_details' ).val( res.sample_details.sample_details );
      $( '#edit_client_address' ).val( res.client_data.address );
      $( '#edit_track_id' ).val( res.sample_details.track_id );
      $( '#edit_remarks' ).val( res.sample_details.remarks );
      var qsFromDate = res.client_data.sent_on;
      $( '#m_datepicker_3A' ).val( qsFromDate );
      $( '#edit_s_id' ).val( rowid );
      $( '#m_modal_edit_samples' ).modal( 'show' );

    }
  } );




}



var DatatableRemoteAjaxDemo = {
  init: function ()
  {

    var e, r, i = $( "#m_form_add_sample" );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        company: {
          required: !0
        },
        name: {
          required: !0
        },

        phone: {
          required: !0,
        },
        client_address: {
          required: !0,
        },
        location: {
          required: !0,
        },
        contact_phone: {
          required: !0,
        },
        sampleBrandType: {
          required: !0,
        },
        selectOrderSize: {
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
            text: "The Sample has been successfully added!",
            type: "success",
            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
            onClose: function ( e )
            {
              window.location.href = BASE_URL + '/sample'
            }
          } )

        }
      } ) )
    } )




    $( '#btnSaveSentInfomration' ).click( function ()
    {
      var courier_details = $( "#courier_id option:selected" ).val();
      var track_id = $( "#track_id" ).val();
      var s_id = $( "#v_s_id" ).val();
      var remarks = $( "#c_remarks" ).val();
      var sent_date = $( "#m_datepicker_3" ).val();
      if ( courier_details == "" )
      {
        swal( {
          title: "Select Courier",
          text: "",
          type: "error",
          confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
          onClose: function ( e )
          {
            console.log( "on close event fired!" )
          }
        } )
        return false;
      }
      if ( track_id == "" )
      {
        swal( {
          title: "Enter Tracking ID",
          text: "",
          type: "error",
          confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
          onClose: function ( e )
          {
            console.log( "on close event fired!" )
          }
        } )
        return false;
      }

      //ajax request
      var formData = {
        's_id': s_id,
        'courier_id': courier_details,
        'track_id': track_id,
        'remarks': remarks,
        'sent_date': sent_date,
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

      };

      $.ajax( {
        url: BASE_URL + '/api/saveSampleCourier',
        type: 'POST',
        data: formData,
        success: function ( res )
        {
          if ( res.status )
          {
            swal( {
              title: "",
              text: "Sample Information successfully updated",
              type: "success",
              confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
              onClose: function ( e )
              {
                location.reload();
              }
            } )
          }
        },
        dataType: 'json'
      } );

      //ajax request

    } );

    var t;
    var delete_ink = BASE_URL + '/delete/sample/';
    var edit_ink = BASE_URL + '/edit/samples/';
    t = $( ".ajax_data_samples" ).mDatatable( {
      data: {
        type: "remote",
        source: {
          read: {
            url: BASE_URL + '/api/getSamplesList',
            data: { _token: 'CSRF_TOKEN' },
            map: function ( t )
            {
              var e = t;
              return void 0 !== t.data && ( e = t.data ), e
            }
          }
        },
        pageSize: 10,
        serverPaging: !0,
        serverFiltering: !0,
        serverSorting: !0
      },
      layout: {
        scroll: !1,
        footer: !1
      },
      sortable: !0,
      pagination: !0,
      toolbar: {
        items: {
          pagination: {
            pageSizeSelect: [ 10, 20, 30, 50, 100 ]
          }
        }
      },
      search: {
        input: $( "#generalSearch" )
      },
      columns: [ {
        field: "sample_id",
        title: "Sample ID",
        sortable: !1,
        width: 100,
        selector: !1,
        textAlign: "center"

      }, {
        field: "client_name",
        title: "Client Name",
        filterable: !1,
        width: 150,


      }, {
        field: "created_by_id",
        title: "Added By",
        template: function ( t )
        {

          var aj = t.created_by_id;
          var e = {
            aj: {
              title: t.created_by,
              class: "warning"
            }
          };
          return t.created_by;
        }

      }, {
        field: "track_id",
        title: "Track ID",
        width: 100
      }, {
        field: "status",
        title: "Status",
        template: function ( t )
        {
          var e = {
            1: {
              title: "NEW",
              class: "m-badge--primary"
            },
            2: {
              title: "SENT",
              class: " m-badge--accent"
            },
            3: {
              title: "RECEIVED",
              class: "m-badge--success"
            },
            4: {
              title: "FEEDBACK",
              class: " m-badge--warnnig"
            }
          };
          return '<span onclick="m_view_sample_details_now(' + t.rowid + ')" title="view sample details" style="cursor:pointer" id="' + t.rowid + '" class="m-badge ' + e[ t.status ].class + ' m-badge--wide">' + e[ t.status ].title + "</span>"
        }

      }, {
        field: "Actions",
        width: 110,
        title: "Actions",
        sortable: !1,
        overflow: "visible",
        template: function ( t, e, a )
        {
          var rowid = t.rowid;
          edit_URL = BASE_URL + '/sample/' + rowid + '/edit';
          return '\t\t\t\t\t\t<a href="' + edit_URL + '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit details"  >\t\t\t\t\t\t\t<i class="la la-edit"></i>\t\t\t\t\t\t</a>\t\t\t\t\t\t<a href="javascript::void(0)" onclick="delete_sample(' + rowid + ')"  class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" title="Delete">\t\t\t\t\t\t\t<i class="la la-trash"></i>\t\t\t\t\t\t</a>\t\t\t\t\t';


        }
      } ]
    } ), $( "#m_form_status_sample" ).on( "change", function ()
    {

      t.search( $( this ).val(), "status" )
    } ), $( "#m_form_sales" ).on( "change", function ()
    {
      t.search( $( this ).val(), "created_by_id" )
    } ), $( "#m_form_status, #m_form_type" ).selectpicker(),
      $( '.m-datatable__table0' ).click( function ( e )
      {          //
        let click_event_name = $( e.target ).closest( '.m-datatable__cell' ).text();
        if ( click_event_name === 'NEW' || click_event_name === 'SENT' || click_event_name === 'RECEIVED' || click_event_name === 'FEEDBACK' )
        {
          let recordID = $( e.target ).closest( '.m-datatable__row' ).find( "span span" ).attr( "id" );
          var formData = {
            'recordID': recordID
          };
          $.ajax( {
            url: BASE_URL + '/api/getSampleDetails',
            type: 'POST',
            data: formData,
            success: function ( res )
            {
              if ( res.sample_details.status_id == 1 )
              {
                $( '.aj_sample_status' ).hide()
                $( '.aj_sample_status_new' ).show()
              } else
              {
                $( '.aj_sample_status' ).show()
                $( '.aj_sample_status_new' ).hide()
              }

              $( '#v_name' ).html( res.client_data.name );
              $( '#user_id' ).html( res.client_data.user_id );
              $( '#v_email' ).html( res.client_data.email );
              $( '#v_phone' ).html( res.client_data.phone );
              $( '#v_companay' ).html( res.client_data.company );
              $( '#v_address' ).html( res.client_data.address );
              $( '#gst_details' ).html( res.client_data.gst_details );
              $( '#brand_name' ).html( res.client_data.brand_name );
              $( '#remarks' ).html( res.client_data.remarks );

              $( '#s_name' ).html( res.agent_data.name );
              $( '#s_email' ).html( res.agent_data.email );
              $( '#s_phone' ).html( res.agent_data.phone );

              $( '#sid_code' ).html( res.sample_details.sample_id );

              $( '#s_id' ).val( recordID );
              $( '#sample_details' ).html( res.sample_details.sample_details );
              $( '#courier_details' ).html( res.sample_details.courier_details );

              $( '#v_track_id' ).html( res.sample_details.track_id );
              $( '#v_created_on' ).html( res.sample_details.created_at );
              $( '#v_status' ).html( res.sample_details.status );
              $( '#v_remarks' ).html( res.sample_details.remarks );
              $( '#v_feedback' ).html( res.sample_details.feedback );
              $( '#v_created_by' ).html( res.sample_details.created_by );
            }
          } );
          $( '#m_view_sample_details' ).modal( 'show' );

        }//end of if new sent etc



      } )

    //code row click


  },
  initTM: function ()
  {
    //saving TM
    var e, r, i = $( "#m_form_add_tmember" );
    e = i.validate( {
      ignore: ":hidden",
      rules: {
        txtTeamName: {
          required: !0
        },
        na8me: {
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
    } ), ( n = i.find( '[data-wizard-action="submitMT"]' ) ).on( "click", function ( r )
    {
      r.preventDefault(), e.form() && ( mApp.progress( n ), i.ajaxSubmit( {
        success: function ()
        {
          mApp.unprogress( n ), swal( {
            title: "",
            text: "The Member has been successfully added!",
            type: "success",
            confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
            onClose: function ( e )
            {
              //window.location.href = BASE_URL + '/add-new-team'
            }
          } )

        }
      } ) )
    } )

    //saving TM

  }

};
jQuery( document ).ready( function ()
{
  DatatableRemoteAjaxDemo.init();
  DatatableRemoteAjaxDemo.initTM();

} );

var DatatablesSearchOptionsAdvancedSearchData_AttenListMASTER = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_1_rawAttenMAster" ).DataTable( {

        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        dom: 'Blfrtip',
        buttons: [

          {
            extend: 'excelHtml5',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdfHtml5',
            exportOptions: {
              columns: ':visible'
            }
          },
          'colvis'
        ],
        ajax: {

          url: BASE_URL + '/getMasterAttenDance',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "emp_id", "emp_name", "month", "present", "half_day", "late_fine", "total_day", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "emp_id"
          }, {
            data: "emp_name"
          }, {
            data: "present"
          },
          {
            data: "half_day"
          },
          {
            data: "late_fine"
          },
          {
            data: "total_day"
          },
          {
            data: "month"
          },

          {
            data: "Actions"
          } ],

        columnDefs: [ {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            console.log( e );

            var html = "";

            html += `<a href="javascript::void(0)" onclick="showAttenCalender(${ e.RecordID })"  title="View Calender" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                             <i class="flaticon-calendar-with-a-clock-time-tools"></i>
                           </a>`


            // html +=`<a href="javascript::void(0)" onclick="delete_rawdata7(${e.rowid})"
            //  title="" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
            //                             <i class="flaticon-rotate "></i>
            //                             </a>`;
            return html;

          }
        },
          // {
          //     targets: 6,
          //     render: function(a, t, e, n) {
          //         var i = {
          //           1: {
          //               title: "RAW",
          //               class: "m-badge--brand"
          //           },
          //           2: {
          //               title: "LEAD",
          //               class: " m-badge--metal"
          //           },
          //           3: {
          //               title: "QUALIFIED",
          //               class: " m-badge--primary"
          //           },
          //           4: {
          //               title: "SAMPLING",
          //               class: " m-badge--success"
          //           },
          //           5: {
          //               title: "CUSTOMER",
          //               class: " m-badge--info"
          //           },
          //           6: {
          //               title: "LOST",
          //               class: " m-badge--danger"
          //           }
          //         };
          //         return void 0 === i[a] ? a : '<span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span>"

          //     }
          // }

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


//my attendace

var DatatablesSearchOptionsAdvancedSearchData_AttenListMASTERMYAtten = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_1_rawAttenMAsterMyAtten" ).DataTable( {

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

          url: BASE_URL + '/getMyMasterAttenDance',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "emp_id", "emp_name", "month", "present", "half_day", "late_fine", "total_day", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "emp_id"
          }, {
            data: "emp_name"
          }, {
            data: "present"
          },
          {
            data: "half_day"
          },
          {
            data: "late_fine"
          },
          {
            data: "total_day"
          },
          {
            data: "month"
          },

          {
            data: "Actions"
          } ],

        columnDefs: [ {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            console.log( e );

            var html = "";

            html += `<a href="javascript::void(0)" onclick="showAttenCalender(${ e.RecordID })"  title="View Calender" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                             <i class="flaticon-calendar-with-a-clock-time-tools"></i>
                           </a>`


            // html +=`<a href="javascript::void(0)" onclick="delete_rawdata7(${e.rowid})"
            //  title="" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
            //                             <i class="flaticon-rotate "></i>
            //                             </a>`;
            return html;

          }
        },
          // {
          //     targets: 6,
          //     render: function(a, t, e, n) {
          //         var i = {
          //           1: {
          //               title: "RAW",
          //               class: "m-badge--brand"
          //           },
          //           2: {
          //               title: "LEAD",
          //               class: " m-badge--metal"
          //           },
          //           3: {
          //               title: "QUALIFIED",
          //               class: " m-badge--primary"
          //           },
          //           4: {
          //               title: "SAMPLING",
          //               class: " m-badge--success"
          //           },
          //           5: {
          //               title: "CUSTOMER",
          //               class: " m-badge--info"
          //           },
          //           6: {
          //               title: "LOST",
          //               class: " m-badge--danger"
          //           }
          //         };
          //         return void 0 === i[a] ? a : '<span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span>"

          //     }
          // }

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



//my attendace


//show showAttenCalender
function showAttenCalender( empID )
{


  var formData = {
    'recordID': empID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getIndividualAttendance',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      $( '.ajviewCalender' ).html( "" );
      $( '.ajviewCalender' ).html( res );



    }
  } );


  $( '#m_modal_AttenCalender' ).modal( 'show' );

}
//show showAttenCalender

var DatatablesSearchOptionsAdvancedSearchData = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_1_raw" ).DataTable( {

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

          url: BASE_URL + '/getRawClientData',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "rowid", "product", "company", "contact", "location", "website", "application", "Status", "p_edit", "p_delete", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "product"
          }, {
            data: "company"
          }, {
            data: "contact"
          },
          {
            data: "location"
          },
          {
            data: "website"
          },
          {
            data: "application"
          },

          {
            data: "Actions"
          } ],
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
            console.log( e.p_edit );
            var html = "";
            edit_URL = BASE_URL + '/rawclientdata/' + e.rowid + '/edit';
            if ( e.p_edit )
            {
              html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
 															<i class="la la-edit"></i>
 														</a>`
            }
            if ( e.p_delete )
            {
              html += `<a href="javascript::void(0)" onclick="delete_rawdata(${ e.rowid })"
                         title="DELETE" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                    <i class="flaticon-delete"></i>
                                                    </a>`
            }
            html += `<a href="javascript::void(0)" onclick="delete_rawdata7(${ e.rowid })"
                       title="ADD ME" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                  <i class="flaticon-rotate "></i>
                                                  </a>`
            return html;
          }
        },
        {
          targets: 6,
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

jQuery( document ).ready( function ()
{
  DatatablesSearchOptionsAdvancedSearchData.init()
  DatatablesSearchOptionsAdvancedSearchData_AttenListMASTER.init()
  DatatablesSearchOptionsAdvancedSearchData_AttenListMASTERMYAtten.init()

} );


//delete_rawdata
function delete_rawdata( rowid )
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
        url: BASE_URL + '/rawclientdata/' + rowid,
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), s_id: rowid, '_method': 'DELETE' },
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


// m_table_PAYMENTREQDATA

var PaymentRequestLIST = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var user_id = $( '#user_id' ).val();
      var a;
      a = $( "#m_table_PAYMENTREQDATA" ).DataTable( {
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
          url: BASE_URL + '/getSamplesListUserWise',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'userid': user_id
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sample_code"
          },
          {
            data: "company"
          },
          {
            data: "phone"
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
            console.log();
            edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
            print_URL = BASE_URL + '/sample/print/' + e.RecordID;

            view_URL = BASE_URL + '/sample/' + e.RecordID + '';

            var html = `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>`;



            return html;
          }
        },
        {
          targets: 7,
          render: function ( a, t, e, n )
          {
            var i = {
              1: {
                title: "NEW",
                class: "m-badge--brand"
              },
              2: {
                title: "SENT",
                class: " m-badge--metal"
              },
              3: {
                title: "RECIEVED",
                class: " m-badge--primary"
              },
              4: {
                title: "FEEDBACK",
                class: " m-badge--success"
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



// m_table_PAYMENTREQDATA




var SampleListUserwise = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var user_id = $( '#user_id' ).val();
      var a;
      a = $( "#m_table_SampletListUserWise" ).DataTable( {
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
          url: BASE_URL + '/getSamplesListUserWise',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'userid': user_id
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sample_code"
          },
          {
            data: "company"
          },
          {
            data: "phone"
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
            console.log();
            edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
            print_URL = BASE_URL + '/sample/print/' + e.RecordID;

            view_URL = BASE_URL + '/sample/' + e.RecordID + '';

            var html = `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>`;



            return html;
          }
        },
        {
          targets: 7,
          render: function ( a, t, e, n )
          {
            var i = {
              1: {
                title: "NEW",
                class: "m-badge--brand"
              },
              2: {
                title: "SENT",
                class: " m-badge--metal"
              },
              3: {
                title: "RECIEVED",
                class: " m-badge--primary"
              },
              4: {
                title: "FEEDBACK",
                class: " m-badge--success"
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



var DatatablesaIngedenentCategoryList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_IngredentCategoryList" ).DataTable( {
        // responsive: !0,
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

          url: BASE_URL + '/getIngredentCategoryList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "category_name", "brand_name", "no_of_ing", "no_of_formula", "no_of_finish_prouduct", "brandCategory", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "category_name"
          },
          {
            data: "brand_name"
          },
          {
            data: "no_of_ing"
          },
          {
            data: "no_of_formula"
          },
          {
            data: "no_of_finish_prouduct"
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
            var editING = BASE_URL + '/edit-ing-category/' + e.RecordID;

            return `
                  <a href="${ editING }"   class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="fa flaticon-edit"></i>
                  </a>
                  <a href="javascript::void(0)" onclick="deleteIngcategory(${ e.RecordID })"   class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                  <i class="fa flaticon-delete"></i>
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


//deleteIngcategory


function deleteIngcategory( rowID )
{
  // @ts-ignore
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
        url: BASE_URL + "/deleteINGCategory",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), rowid: rowID },
        success: function ( resp )
        {
          console.log( resp );
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
            swal( "Deleted!", "Successfully Deleted", "success" ).then( function ( eyz )
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

//deleteIngcategory




//m_table_IngredentBrandList
var DatatablesaIngedenentBrandList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;

      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_IngredentBrandList" ).DataTable( {
        // responsive: !0,
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

          url: BASE_URL + '/getIngredentBrandList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "brand_name", "supplier_name", "no_of_ing", "no_of_formula", "no_of_finish_prouduct", "brandCategory", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "brand_name"
          },
          {
            data: "supplier_name"
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
            var str = '';
            var editING = BASE_URL + '/edit-ing-brand/' + e.RecordID;

            //   str +=`<a href="javascript::void(0)" onclick="viewIngBrandDetails(${e.RecordID})"  class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
            //   <i class="fa flaticon-eye"></i>
            // </a>`;

            str += `<a href="${ editING }"   class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="fa flaticon-edit"></i>
                  </a>`;
            if ( UID == 1 )
            {
              str += ` <a href="javascript::void(0)" onclick="deleteIngBrandDetails(${ e.RecordID })"   class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="fa flaticon-delete"></i>
                  </a>`;
            }

            return str;



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

function viewIngBrandDetails( rowID )
{
  //ajcode
  //ajax call
  var HTML = "";
  var formData = {
    'rowid': rowID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getIngredentBrandListID',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      console.log( res.link_brands );
      $( '.viewDetailsING' ).html( "" );

      HTML += `<div class="m-section">
										
       <div class="m-section__content">
         <table class="table">      

           <tbody>
             <tr>														
               <td><b>Brand Name:</b></td>
               <td>${ res.brand_name }</td>															
             </tr>
             <tr>														
             <td><b>Supplier Name:</b></td>
             <td>${ res.supplier_name }</td>															
            </tr>	
            <tr>														
             <td><b>No .of Ingredient:</b></td>
             <td>${ res.no_of_ing }</td>															
            </tr>	
            <tr>														
            <td><b>No .of Formulation:</b></td>
            <td>${ res.no_of_formula }</td>															
           </tr>

           <tr>														
            <td><b>No .of Finish  Product:</b></td>
            <td>${ res.no_of_finish_prouduct }</td>															
           </tr>


           </tbody>
         </table>
       </div>
     </div>`;



      HTML += `</tbody>
  </table>
</div>
</div>
`;

      $( '.viewDetailsING' ).append( HTML );

      $( '#m_modal_4ING_DETAILBrand' ).modal( 'show' )
    },
    dataType: 'json'
  } );

  //ajax call
  //ajcode

}


function deleteIngBrandDetails( rowID )
{
  // @ts-ignore
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
        url: BASE_URL + "/deleteINGBrand",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), rowid: rowID },
        success: function ( resp )
        {
          console.log( resp );
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
            swal( "Deleted!", "Successfully Deleted", "success" ).then( function ( eyz )
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
//m_table_RNDFormulation
//m_table_RNDFormulationView
//m_table_RNDFormulation

//m_table_Ingredients
var DatatablesaIngedientsPrice = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_IngredientsPrice" ).DataTable( {
        // responsive: !0,
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

          url: BASE_URL + '/getIngredientsPrice',
          type: "POST",
          data: {
            columnsDef: [
              "RecordID",
              "name",
              "cat_id",
              "ing_brand_name",
              "ppkg",
              "recommandation_dose",
              "spz",
              "av_lose",
              "lead_type",
              "sap_code",
              "SRHTML",
              "size_1",
              "price_1",
              "size_2",
              "price_2",
              "size_3",
              "price_3",
              "customFileCOA",
              "customFileMSDS",
              "customFileGS",
              "Actions"
            ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "name"
          },
          {
            data: "cat_id"
          },
          {
            data: "size_1"
          },
          {
            data: "price_1"
          },
          {
            data: "size_2"
          },
          {
            data: "price_2"
          },
          {
            data: "size_3"
          },
          {
            data: "price_3"
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
            if ( _UNIB_RIGHT == 'SalesUser' || _UNIB_RIGHT == 'Intern' )
            {
              var editING = BASE_URL + '/edit-ingrednts/' + e.RecordID;
              var HTML = "";


              if ( e.customFileCOA !== null )
              {
                HTML += ` 
            <a type="application/pdf" title="Download COA" target="_blank" href="${ e.customFileCOA }" class="m-link m-link--state m-link--primary"><b>COA</b></a>          
              `;
              }
              if ( e.customFileMSDS !== null )
              {
                HTML += ` 
            <a type="application/pdf" title="Download MSDS" target="_blank"  href="${ e.customFileMSDS }" class="m-link m-link--state m-link--warning"><b>MSDS</b></a>          
              `;
              }
              if ( e.customFileGS !== null )
              {
                HTML += ` 
            <a type="application/pdf" title="Download GC"  target="_blank"  href="${ e.customFileGS }" class="m-link m-link--state m-link--primary"><b>GC</b></a>          
              `;
              }

              return HTML;
            }

            if ( _UNIB_RIGHT == 'KSalesUser' )
            {
              var editING = BASE_URL + '/edit-ingrednts/' + e.RecordID;
              var HTML = "";
              HTML += ``;

              if ( e.customFileCOA !== null )
              {
                HTML += ` 
            <a type="application/pdf" title="Download COA" target="_blank" href="${ e.customFileCOA }" class="m-link m-link--state m-link--primary"><b>COA</b></a>          
              `;
              }
              if ( e.customFileMSDS !== null )
              {
                HTML += ` 
            <a type="application/pdf" title="Download MSDS" target="_blank"  href="${ e.customFileMSDS }" class="m-link m-link--state m-link--warning"><b>MSDS</b></a>          
              `;
              }
              if ( e.customFileGS !== null )
              {
                HTML += ` 
            <a type="application/pdf" title="Download GC"  target="_blank"  href="${ e.customFileGS }" class="m-link m-link--state m-link--primary"><b>GC</b></a>          
              `;
              }

              return HTML;
            } else
            {
              if ( UID == 27 )
              {
                var editING = BASE_URL + '/edit-ingrednts/' + e.RecordID;
                var HTML = "";
                HTML += `<a href="${ editING }"   class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                <i class="fa flaticon-edit"></i>
              </a>
             
              <br>`;

                if ( e.customFileCOA !== null )
                {
                  HTML += ` 
              <a type="application/pdf" title="Download COA" target="_blank" href="${ e.customFileCOA }" class="m-link m-link--state m-link--primary"><b>COA</b></a>          
                `;
                }
                if ( e.customFileMSDS !== null )
                {
                  HTML += ` 
              <a type="application/pdf" title="Download MSDS" target="_blank"  href="${ e.customFileMSDS }" class="m-link m-link--state m-link--warning"><b>MSDS</b></a>          
                `;
                }
                if ( e.customFileGS !== null )
                {
                  HTML += ` 
              <a type="application/pdf" title="Download GC"  target="_blank"  href="${ e.customFileGS }" class="m-link m-link--state m-link--primary"><b>GC</b></a>          
                `;
                }

                return HTML;
              }
              return "";
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
    },
    initAB: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_RNDFormulation" ).DataTable( {
        // responsive: !0,
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

          url: BASE_URL + '/getRNDFormulataList',
          type: "GET",
          data: {
            columnsDef: [
              "RecordID",
              "formula_name",
              "fm_code",
              "mfg_qty",
              "created_by",
              "created_at",
              "status",
              "created_by",
              "created_name",
              "totalcost",
              "Actions"
            ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "formula_name"
          },
          {
            data: "fm_code"
          },       
         
          {
            data: "created_at"
          },
          {
            data: "created_name"
          },
          {
            data: "status"
          },
          {
            data: "totalcost"
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
              var viewRND = BASE_URL + '/rnd-ingrednts-formula/' + e.RecordID;
              var viewRNDCost = BASE_URL + '/rnd-ingrednts-formula-cost/' + e.RecordID;
              var printRND = BASE_URL + '/rnd-ingrednts-print/' + e.RecordID;
              var editRND = BASE_URL + '/ingredients-formulation-edit/' + e.RecordID;
              var copyRND = BASE_URL + '/copy-ingredients-formulation/' + e.RecordID;

              var HTML = "";
              if(UID == 89 || UID==206){
                HTML += `<a target="_blank" href="${ viewRND }" style="margin:1px;" class=" btn btn-success btn-sm m-btn 	m-btn m-btn--icon">
                <span>
                    FORMULA 
    
                </span>
            </a>`;
            HTML += `<a  href="javascript::void(0)" onclick="showBatchSizr(${ e.RecordID })" style="margin:1px;" class=" btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
            <span>
               BATCH 
  
            </span>
        </a>`;
        HTML += `<a target="_blank"  href="${editRND}"  style="margin:1px;" class=" btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
        <span>
          EDIT

        </span>
    </a>`;
    
    HTML += `<a target="_blank"  href="${copyRND}"  style="margin:1px;" class=" btn btn-wa btn-sm m-btn 	m-btn m-btn--icon">
    <span>
      <i class="la la-copy"></i> COPY

    </span>
</a>`;
    if(UID!=1){
      HTML +=`<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sampleRNDFormula(${ e.RecordID})" title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
      <i class="la la-trash"></i>
      </a>`;
    }

     
        

            return HTML;
            
    
              }


              HTML += `<a target="_blank" href="${ viewRND }" style="margin:1px;" class=" btn btn-success btn-sm m-btn 	m-btn m-btn--icon">
              <span>
                  FORMULA 

              </span>
          </a>`;
         
         

              if ( UID == 1 || UID==186 )
              {
                HTML += `<a target="_blank"  href="${ viewRNDCost }" style="margin:1px;" class=" btn btn-success btn-sm m-btn 	m-btn m-btn--icon">
                <span>
                    COSTING 
      
                </span>
            </a>`;
            
                HTML += `<a  href="javascript::void(0)" onclick="showBatchSizr(${ e.RecordID })" style="margin:1px;" class=" btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
            <span>
               BATCH 
  
            </span>
        </a>`;

              }



              HTML += `<a href="{{route('mapRNDSampleList')}}" onclick="showSampleMapA(${ e.RecordID })" style="margin: 1px;" class=" btn btn-success btn-sm m-btn 	m-btn m-btn--icon">
              <span>
              <span class="m-badge m-badge--warning">
              0

           </span>
            SAMPLE

              </span>
          </a>`;
          
if(e.status==1){

}else{
  HTML += `<a target="_blank"  href="${editRND}"  style="margin:1px;" class=" btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
          <span>
            EDIT

          </span>
      </a>`;
      if(UID!=1){
        HTML +=`<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sampleRNDFormula(${ e.RecordID})" title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
        <i class="la la-trash"></i>
        </a>`;
      }

}
        
      
      HTML += `<a target="_blank" href="${copyRND}"  style="margin:1px;" class=" btn btn-wa btn-sm m-btn 	m-btn m-btn--icon">
      <span>
        <i class="la la-copy"></i> COPY

      </span>
  </a>`;

 

 


              return HTML;







            }
          },
          {
            targets: 5,
            render: function(a, t, e, n) {
                var i = {
                  
                    
                    0: {
                        title: "DRAFT",
                        class: " m-badge--secondary"
                    },
                    1: {
                        title: "COMPLETED",
                        class: " m-badge--success"
                    },
                   
                    2: {
                        title: "REJECTED",
                        class: " m-badge--danger"
                    },
                   
                };
                if(UID!=1){
                  if(e.status==0){
                    return void 0 === i[a] ? a : '<a href="#" onclick="updateRNDFormulationStatus('+e.RecordID+')" ><span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span></a>"
                  }else{
                    return void 0 === i[a] ? a : '<a href="#" onclick="NoupdateRNDFormulationStatus('+e.RecordID+')" ><span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span></a>"
                  }
                  

                }else{
                  return void 0 === i[a] ? a : '<a href="#" onclick="updateRNDFormulationStatus('+e.RecordID+')" ><span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span></a>"
                }
                
            }
        }, 
        {
          targets: 6,
          render: function(a, t, e, n) {
            if(UID==1 || UID==186){
              return e.totalcost;
            }else{
              return '';
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
    },
    initABBASE: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_Base_RNDFormulation" ).DataTable( {
        // responsive: !0,
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

          url: BASE_URL + '/getRNDFormulataListBase',
          type: "GET",
          data: {
            columnsDef: [
              "RecordID",
              "formula_name",
              "fm_code",
              "mfg_qty",
              "created_by",
              "created_at",
              "status",
              "created_by",
              "created_name",
              "totalcost",
              "Actions"
            ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "formula_name"
          },
          {
            data: "fm_code"
          },        
         
          {
            data: "created_at"
          },
          {
            data: "created_name"
          },
          {
            data: "status"
          },
          {
            data: "totalcost"
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

             // var viewRND = BASE_URL + '/rnd-ingrednts-formula/' + e.RecordID;
              // var viewRNDCost = BASE_URL + '/rnd-ingrednts-formula-cost/' + e.RecordID;
              // var printRND = BASE_URL + '/rnd-ingrednts-print/' + e.RecordID;
              // var editRND = BASE_URL + '/ingredients-formulation-edit/' + e.RecordID;
              //var copyRND = BASE_URL + '/copy-ingredients-formulation/' + e.RecordID;


              var viewRND = BASE_URL + '/formula-base/' + e.RecordID;
              var viewRNDCost = BASE_URL + '/formula-cost-base/' + e.RecordID;              
              var printRND = BASE_URL + '/formula-view-base/' + e.RecordID;

              var editRND = BASE_URL + '/formula-edit/' + e.RecordID;
              var copyRND = BASE_URL + '/copy-formula-base-formulation/' + e.RecordID;
              

              var HTML = "";

           

              if(UID == 89){

               
            HTML += `<a  href="javascript::void(0)" onclick="showBatchSizr(${ e.RecordID })" style="margin:1px;" class=" btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
            <span>
               BATCH 
  
            </span>
        </a>`;
        HTML += `<a target="_blank"  href="${editRND}"  style="margin:1px;" class=" btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
        <span>
          EDIT

        </span>
    </a>`;
    
   
    if(UID!=1){
      
    }
            
    
              }


              HTML += `<a href="${ viewRND }" style="margin:1px;" class=" btn btn-success btn-sm m-btn 	m-btn m-btn--icon">
              <span>
                  FORMULA 

              </span>
          </a>`;
         
         if(UID==206){
          HTML += `<a  href="javascript::void(0)" onclick="showBatchSizr(${ e.RecordID })" style="margin:1px;" class=" btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
          <span>
             BATCH 

          </span>
      </a>`;
      
         }

              if ( UID == 1 || UID==186 )
              {
                HTML += `<a href="${ viewRNDCost }" style="margin:1px;" class=" btn btn-success btn-sm m-btn 	m-btn m-btn--icon">
                <span>
                    COSTING 
      
                </span>
            </a>`;
            
                HTML += `<a  href="javascript::void(0)" onclick="showBatchSizr(${ e.RecordID })" style="margin:1px;" class=" btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
            <span>
               BATCH 
  
            </span>
        </a>`;

              }



              HTML += `<a href="javascript::void(0)" onclick="showSampleMap(${ e.RecordID })" style="margin: 1px;" class=" btn btn-success btn-sm m-btn 	m-btn m-btn--icon">
              <span>
              <span class="m-badge m-badge--warning">
              0

           </span>
            SAMPLE

              </span>
          </a>`;
          
if(e.status==1){
  if(UID==206){
    HTML += `<a target="_blank"  href="${editRND}"  style="margin:1px;" class=" btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
    <span>
      EDIT

    </span>
</a>`;
  }
 
}else{
  HTML += `<a target="_blank"  href="${editRND}"  style="margin:1px;" class=" btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
          <span>
            EDIT

          </span>
      </a>`;
}

 if(UID!=1){
    HTML +=`<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sampleRNDFormulaBase(${ e.RecordID})" title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
    <i class="la la-trash"></i>
    </a>`;
  }  
   
  HTML += `<a target="_blank"  href="#"  style="margin:1px;" class=" btn btn-wa btn-sm m-btn 	m-btn m-btn--icon">
  <span>
    <i class="la la-copy"></i> COPY

  </span>
</a>`;


  return HTML;
  
}
          },
          {
            targets: 5,
            render: function(a, t, e, n) {
                var i = {
                  
                    
                    0: {
                        title: "DRAFT",
                        class: " m-badge--secondary"
                    },
                    1: {
                        title: "COMPLETED",
                        class: " m-badge--success"
                    },
                   
                    2: {
                        title: "REJECTED",
                        class: " m-badge--danger"
                    },
                   
                };
                if(UID!=1){
                  if(e.status==0){
                    return void 0 === i[a] ? a : '<a href="#" onclick="updateRNDFormulationStatus('+e.RecordID+')" ><span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span></a>"
                  }else{
                    return void 0 === i[a] ? a : '<a href="#" onclick="NoupdateRNDFormulationStatus('+e.RecordID+')" ><span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span></a>"
                  }
                  

                }else{
                  return void 0 === i[a] ? a : '<a href="#" onclick="updateRNDFormulationStatus('+e.RecordID+')" ><span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span></a>"
                }
                
            }
        }, 
        {
          targets: 6,
          render: function(a, t, e, n) {
            if(UID==1 || UID==186){
              return e.totalcost;
            }else{
              return '';
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
    },
    initABBASE_FROM: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_Base_RNDFormulationFrom" ).DataTable( {
        // responsive: !0,
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

          url: BASE_URL + '/getRNDFormulataListBaseFrom',
          type: "GET",
          data: {
            columnsDef: [
              "RecordID",
              "formula_name",
              "fm_code",
              "mfg_qty",
              "created_by",
              "created_at",
              "status",
              "created_by",
              "created_name",
              "totalcost",
              "Actions"
            ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "formula_name"
          },
          {
            data: "fm_code"
          },        
         
          {
            data: "created_at"
          },
          {
            data: "created_name"
          },
          {
            data: "status"
          },
          {
            data: "totalcost"
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

             // var viewRND = BASE_URL + '/rnd-ingrednts-formula/' + e.RecordID;
              // var viewRNDCost = BASE_URL + '/rnd-ingrednts-formula-cost/' + e.RecordID;
              // var printRND = BASE_URL + '/rnd-ingrednts-print/' + e.RecordID;
              // var editRND = BASE_URL + '/ingredients-formulation-edit/' + e.RecordID;
              //var copyRND = BASE_URL + '/copy-ingredients-formulation/' + e.RecordID;


              var viewRND = BASE_URL + '/formula-base-from/' + e.RecordID;
              var viewRNDCost = BASE_URL + '/formula-cost-base/' + e.RecordID;              
              var printRND = BASE_URL + '/formula-view-base/' + e.RecordID;

              var editRND = BASE_URL + '/formula-edit/' + e.RecordID;
              var copyRND = BASE_URL + '/copy-formula-base-formulation/' + e.RecordID;
              

              var HTML = "";

           if(UID==1 || UID==206){

            HTML += `<a  href="javascript::void(0)" onclick="showBatchSizr(${ e.RecordID })" style="margin:1px;" class=" btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
            <span>
               BATCH 
  
            </span>
        </a>`;

        HTML += `<a href="${ viewRND }" style="margin:1px;" class=" btn btn-success btn-sm m-btn 	m-btn m-btn--icon">
        <span>
            FORMULA 

        </span>
    </a>`;
            

           }
           return HTML;

              if(UID == 89){

               
            HTML += `<a  href="javascript::void(0)" onclick="showBatchSizr(${ e.RecordID })" style="margin:1px;" class=" btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
            <span>
               BATCH 
  
            </span>
        </a>`;
        HTML += `<a target="_blank"  href="${editRND}"  style="margin:1px;" class=" btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
        <span>
          EDIT

        </span>
    </a>`;
    
   
    if(UID!=1){
      
    }
            
    
              }


              HTML += `<a href="${ viewRND }" style="margin:1px;" class=" btn btn-success btn-sm m-btn 	m-btn m-btn--icon">
              <span>
                  FORMULA 

              </span>
          </a>`;
         
         if(UID==206){
          HTML += `<a  href="javascript::void(0)" onclick="showBatchSizr(${ e.RecordID })" style="margin:1px;" class=" btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
          <span>
             BATCH 

          </span>
      </a>`;
      
         }

              if ( UID == 1 || UID==186 )
              {
                HTML += `<a href="${ viewRNDCost }" style="margin:1px;" class=" btn btn-success btn-sm m-btn 	m-btn m-btn--icon">
                <span>
                    COSTING 
      
                </span>
            </a>`;
            
                HTML += `<a  href="javascript::void(0)" onclick="showBatchSizr(${ e.RecordID })" style="margin:1px;" class=" btn btn-warning btn-sm m-btn 	m-btn m-btn--icon">
            <span>
               BATCH 
  
            </span>
        </a>`;

              }



              HTML += `<a href="javascript::void(0)" onclick="showSampleMap(${ e.RecordID })" style="margin: 1px;" class=" btn btn-success btn-sm m-btn 	m-btn m-btn--icon">
              <span>
              <span class="m-badge m-badge--warning">
              0

           </span>
            SAMPLE

              </span>
          </a>`;
          
if(e.status==1){
  if(UID==206){
    HTML += `<a target="_blank"  href="${editRND}"  style="margin:1px;" class=" btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
    <span>
      EDIT

    </span>
</a>`;
  }
 
}else{
  HTML += `<a target="_blank"  href="${editRND}"  style="margin:1px;" class=" btn btn-primary btn-sm m-btn 	m-btn m-btn--icon">
          <span>
            EDIT

          </span>
      </a>`;
}

 if(UID!=1){
    HTML +=`<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sampleRNDFormulaBase(${ e.RecordID})" title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
    <i class="la la-trash"></i>
    </a>`;
  }  
   
  HTML += `<a target="_blank"  href="#"  style="margin:1px;" class=" btn btn-wa btn-sm m-btn 	m-btn m-btn--icon">
  <span>
    <i class="la la-copy"></i> COPY

  </span>
</a>`;


  return HTML;
  
}
          },
          {
            targets: 5,
            render: function(a, t, e, n) {
                var i = {
                  
                    
                    0: {
                        title: "DRAFT",
                        class: " m-badge--secondary"
                    },
                    1: {
                        title: "COMPLETED",
                        class: " m-badge--success"
                    },
                   
                    2: {
                        title: "REJECTED",
                        class: " m-badge--danger"
                    },
                   
                };
                if(UID!=1){
                  if(e.status==0){
                    return void 0 === i[a] ? a : '<a href="#" onclick="updateRNDFormulationStatus('+e.RecordID+')" ><span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span></a>"
                  }else{
                    return void 0 === i[a] ? a : '<a href="#" onclick="NoupdateRNDFormulationStatus('+e.RecordID+')" ><span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span></a>"
                  }
                  

                }else{
                  return void 0 === i[a] ? a : '<a href="#" onclick="updateRNDFormulationStatus('+e.RecordID+')" ><span class="m-badge ' + i[a].class + ' m-badge--wide">' + i[a].title + "</span></a>"
                }
                
            }
        }, 
        {
          targets: 6,
          render: function(a, t, e, n) {
            if(UID==1 || UID==186){
              return e.totalcost;
            }else{
              return '';
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
    },
    initABC: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_RNDFormulationView" ).DataTable( {
        // responsive: !0,
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

          url: BASE_URL + '/getRNDFormulataListView',
          type: "GET",
          data: {
            columnsDef: [
              "RecordID",
              "ingredent_name",
              "dos_percentage",
              "mfg_pecentage",
              "phase",
              "price",
              "cost",
              "created_by_name",
              "Actions"
            ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            sample_action: sample_action

          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "ingredent_name"
          },

          {
            data: "dos_percentage"
          },
          {
            data: "mfg_pecentage"
          },
          {
            data: "phase"
          },
          {
            data: "cost"
          },
          {
            data: "created_by_name"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 3 ],
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
          {
            targets: 5,
            title: "Cost",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              if ( UID == 1 )
              {
                return e.cost;
              } else
              {
                return '--';
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
    },


  }
}();

//btnDownLoadAttenPDF
$( '#btnDownLoadAttenPDF' ).click( function ()
{


  var URL = BASE_URL + "/download-atten-pdf";
  window.location.href = URL;



} );

//btnDownLoadAttenPDF

//m_table_Ingredients
//btnDownLoadRndPrice
$( '#btnDownLoadRndPrice' ).click( function ()
{
  var selectCatName = $( '#catIDPrice :selected' ).val();
  if ( selectCatName == "" )
  {
    toastr.error( 'Please Select Category  ', 'RND' );
    //location.reload();
    return true;
  }

  var URL = BASE_URL + "/download-rnd-pdf/" + selectCatName;
  window.location.href = URL;



} );
//btnDownLoadRndPrice
//btnDownLoadRndPriceSample
$( '#btnDownLoadRndPriceSample' ).click( function ()
{
  var selectCatName = $( '#catIDPrice :selected' ).val();
  if ( selectCatName == "" )
  {
    toastr.error( 'Please Select Category  ', 'RND' );
    //location.reload();
    return true;
  }

  var URL = BASE_URL + "/download-rnd-pdfsample/" + selectCatName;
  window.location.href = URL;



} );

//btnDownLoadRndPriceSample


//m_table_Ingredients
var DatatablesaIngedients = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_Ingredients" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ [ 10, 25, 50, -1 ], [ 10, 25, 50, "All" ] ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getIngredients',
          type: "POST",
          data: {
            columnsDef: [
              "RecordID",
              "name",
              "inci",
              "cat_id",
              "ing_brand_name",
              "ppkg",
              "recommandation_dose",
              "spz",
              "av_lose",
              "lead_type",
              "sap_code",
              "size_1",
              "price_1",
              "size_2",
              "price_2",
              "size_3",
              "price_3",
              "ingb_other_name",
              "SRHTML",
              "customFileCOA",
              "customFileMSDS",
              "customFileGS",
              "Actions"
            ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "name"
          },
          {
            data: "cat_id"
          },
          {
            data: "ingb_other_name"
          },


          {
            data: "size_1"
          },
          {
            data: "price_1"
          },
          {
            data: "size_2"
          },
          {
            data: "price_2"
          },
          {
            data: "size_3"
          },
          {
            data: "price_3"
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

            if ( _UNIB_RIGHT == "Admin" || _UNIB_RIGHT == "CourierTrk" )
            {
              var editING = BASE_URL + '/edit-ingrednts/' + e.RecordID;
              var HTML = "";
              HTML += `<a href="${ editING }"   class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
              <i class="fa flaticon-edit"></i>
            </a>
            <a href="javascript::void(0)" onclick="deleteIngredients(${ e.RecordID })"   class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
            <i class="fa flaticon-delete"></i>
          </a><br>`;

              if ( e.customFileCOA !== null )
              {
                HTML += ` 
            <a type="application/pdf" title="Download COA" target="_blank" href="${ e.customFileCOA }" class="m-link m-link--state m-link--primary"><b>COA</b></a>          
              `;
              }
              if ( e.customFileMSDS !== null )
              {
                HTML += ` 
            <a type="application/pdf" title="Download MSDS" target="_blank"  href="${ e.customFileMSDS }" class="m-link m-link--state m-link--warning"><b>MSDS</b></a>          
              `;
              }
              if ( e.customFileGS !== null )
              {
                HTML += ` 
            <a type="application/pdf" title="Download GC"  target="_blank"  href="${ e.customFileGS }" class="m-link m-link--state m-link--primary"><b>GC</b></a>          
              `;
              }

              return HTML;
            } else
            {
              if ( UID == 27 )
              {
                var editING = BASE_URL + '/edit-ingrednts/' + e.RecordID;
                var HTML = "";
                HTML += `<a href="${ editING }"   class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                <i class="fa flaticon-edit"></i>
              </a>
             
              <br>`;

                if ( e.customFileCOA !== null )
                {
                  HTML += ` 
              <a type="application/pdf" title="Download COA" target="_blank" href="${ e.customFileCOA }" class="m-link m-link--state m-link--primary"><b>COA</b></a>          
                `;
                }
                if ( e.customFileMSDS !== null )
                {
                  HTML += ` 
              <a type="application/pdf" title="Download MSDS" target="_blank"  href="${ e.customFileMSDS }" class="m-link m-link--state m-link--warning"><b>MSDS</b></a>          
                `;
                }
                if ( e.customFileGS !== null )
                {
                  HTML += ` 
              <a type="application/pdf" title="Download GC"  target="_blank"  href="${ e.customFileGS }" class="m-link m-link--state m-link--primary"><b>GC</b></a>          
                `;
                }

                return HTML;
              }
              return "";
            }




          }
        },
        {
          targets: 3,
          title: "Alias with INCI",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            if ( typeof e.ingb_other_name !== "undefined" )
            {
              var oname = "NA";
            } else
            {
              var oname = e.ingb_other_name;
            }


            return `OtherName:${ oname }<br>
                    INCI: ${ e.inci }
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

//m_table_Ingredients

function deleteIngredients( rowID )
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
        url: BASE_URL + "/deleteIngredient",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), rowid: rowID },
        success: function ( resp )
        {
          console.log( resp );
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
            swal( "Deleted!", "Successfully Deleted", "success" ).then( function ( eyz )
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

//m_table_RND_finishProductList_salesDash
var DatatableRNDFinishProductList_salesDash = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_RND_finishProductList_salesDash" ).DataTable( {
        // responsive: !0,
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

          url: BASE_URL + '/getFinishProductList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "sp_min", "sp_max", "order_recieved", "sample_sent", "product_name", "cat", "subcat", "sap_code", "chemist_by", "cost_price", "company_brands",
              "size_1",
              "size_2",
              "size_3",
              "price_1",
              "price_2",
              "price_3",
              "grade_id",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },

          {
            data: "product_name"
          },
          {
            data: "grade_id"
          },
          {
            data: "cat"
          },
          {
            data: "subcat"
          },
          {
            data: "size_1"
          },
          {
            data: "price_1"
          },
          {
            data: "size_2"
          },
          {
            data: "price_2"
          },
          {
            data: "size_3"
          },
          {
            data: "price_3"
          },


          {
            data: "order_recieved"
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
            title: "ActionsK",
            width: 200,
            orderable: !1,
            render: function ( a, t, e, n )
            {
              // return '';
              var editING = BASE_URL + '/edit-finish-product/' + e.RecordID;

              return `                 
                <a href="javascript::void(0)" title="view" onclick="ViewFinishPRDetails(${ e.RecordID })"   class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                <i class="fa flaticon-eye"></i>
              </a>
              

                `;



            }
          },



          {
            targets: 1,
            width: 200,
            render: function ( a, t, e, n )
            {

              return `${ e.product_name }`;





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


//ajcode:
var DatatableRNDFinishProductList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_RND_finishProductList" ).DataTable( {
        // responsive: !0,
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

          url: BASE_URL + '/getFinishProductList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "sp_min", "sp_max", "order_recieved", "sample_sent", "product_name", "cat", "subcat", "sap_code", "chemist_by", "cost_price", "company_brands",
              "size_1",
              "size_2",
              "size_3",
              "price_1",
              "price_2",
              "price_3",
              "grade_id",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },

          {
            data: "product_name"
          },
          {
            data: "grade_id"
          },
          {
            data: "cat"
          },
          {
            data: "subcat"
          },
          {
            data: "size_1"
          },
          {
            data: "price_1"
          },
          {
            data: "size_2"
          },
          {
            data: "price_2"
          },
          {
            data: "size_3"
          },
          {
            data: "price_3"
          },


          {
            data: "order_recieved"
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
            width: 200,
            orderable: !1,
            render: function ( a, t, e, n )
            {
              if ( _UNIB_RIGHT == "Intern" || UID == 172 ||  UID == 217 || UID == 202 || UID==185)
              {
                return ` <a href="javascript::void(0)" title="view" onclick="ViewFinishPRDetails(${ e.RecordID })"   class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                <i class="fa flaticon-eye"></i>
              </a>`
              }
              var editING = BASE_URL + '/edit-finish-product/' + e.RecordID;

              return `
                  <a href="${ editING }"   class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="fa flaticon-edit"></i>
                  </a>
                  <a href="javascript::void(0)" onclick="deleteFinishDelete(${ e.RecordID })"   class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                  <i class="fa flaticon-delete"></i>
                </a>
                <a href="javascript::void(0)" title="view" onclick="ViewFinishPRDetails(${ e.RecordID })"   class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                <i class="fa flaticon-eye"></i>
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

//ViewFinishPRDetails
function ViewFinishPRDetails( rowID )
{
  $( '#txtFPID' ).val( rowID );
  //clsFPDetails
  var formData = {
    'FPID': rowID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getFinishProductDataList',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '.clsFPDetails' ).html( '' );
      $( '.clsFPDetails' ).html( res.HTML_FPLIST );

    },
    dataType: 'json'

  } );


  $( '#m_modal_ViewFinishPRDetails' ).modal( 'show' );

}
//ViewFinishPRDetails

//ajcode:
function setFProductSPRange( rowID )
{
  $( '#txtPFSPMinMax' ).val( rowID );
  $( '#m_modal_FPLISt' ).modal( 'show' );
}

$( '#btnSaveSPRange' ).click( function ()
{
  var spMin = $( "input[name=txtSPMin]" ).val();
  var spMax = $( "input[name=txtSPMax]" ).val();
  var rowid = $( '#txtPFSPMinMax' ).val();

  var formData = {
    'spMin': spMin,
    'spMax': spMax,
    'rowid': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setSPRange',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      toastr.success( 'Added  ', 'Range' );
      location.reload();
      return true;

    }
  } );

} );

function deleteFinishDelete( rowID )
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
        url: BASE_URL + "/deleteFinishProduct",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), rowid: rowID },
        success: function ( resp )
        {
          console.log( resp );
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
            swal( "Deleted!", "Successfully Deleted", "success" ).then( function ( eyz )
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




// 
var DatatableFinishProductSubCatList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_finishproduct_subcatlistData" ).DataTable( {
        // responsive: !0,
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

          url: BASE_URL + '/getFinishProductcatSubListData',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "created_at", "cat_name", "sub_cat_name", "no_product", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sub_cat_name"
          },
          {
            data: "cat_name"
          },

          {
            data: "no_product"
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
        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
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


var DatatableFinishProductCatList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_finishproduct_catlist" ).DataTable( {
        // responsive: !0,
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

          url: BASE_URL + '/getFinishProductCAT',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "created_at", "cat_name", "sub_cat_name", "no_product", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "cat_name"
          },
          {
            data: "sub_cat_name"
          },


          {
            data: "no_product"
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
        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
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



var DatatableNewProductDevelopment = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_new_product_list" ).DataTable( {
        // responsive: !0,
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

          url: BASE_URL + '/getNewProductDevelopementList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "created_at", "type", "name", "sub_category", "URL", "benchmark_provided",
              "color",
              "npd_stage",
              "sp", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "created_at"
          },
          {
            data: "name"
          },
          {
            data: "type"
          },
          {
            data: "sub_category"
          },
          {
            data: "benchmark_provided"
          },
          {
            data: "npd_stage"
          },
          {
            data: "sp"
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
        columnDefs: [
          {
            targets: [ 0 ],
            visible: !1
          },
          {
            targets: 6,
            title: "NPD Stages",
            width: 200,
            orderable: !1,
            render: function ( a, t, e, n )
            {
              var pid = 3;




              return `<a href="javascript::void(0)" onclick="GeneralViewStageRND(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                                
                  ${ e.npd_stage }
               
              </a>`;



            }

          },

          {
            targets: -1,
            title: "Actions",
            width: 200,
            orderable: !1,
            render: function ( a, t, e, n )
            {
              var editING = BASE_URL + '/edit-new-product/' + e.RecordID;

              if(UID==1){
                return `<a href="javascript::void(0)" onclick="viewIngDetails(${ e.RecordID })"  class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                <i class="fa flaticon-eye"></i>
              </a>
              <a href="${ editING }"   class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                <i class="fa flaticon-edit"></i>
              </a>
              <a href="javascript::void(0)" onclick="deleteNewPDev(${ e.RecordID })"   class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
              <i class="fa flaticon-delete"></i>
            </a>`;
              }else{
                return `<a href="javascript::void(0)" onclick="viewIngDetails(${ e.RecordID })"  class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                <i class="fa flaticon-eye"></i>
              </a>`;
            
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




// ingredent list
function deleteNewPDev( rowID )
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
        url: BASE_URL + "/deleteNewProductDev",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), rowid: rowID },
        success: function ( resp )
        {
          console.log( resp );
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
            swal( "Deleted!", "Successfully Deleted", "success" ).then( function ( eyz )
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


//m_table_IngredentBrandList

// ingredent list
//datagrid Client list

var DatatablesaIngedenentList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_IngredentList" ).DataTable( {
        // responsive: !0,
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

          url: BASE_URL + '/getIngredentList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "company_name", "contact_person", "contact_phone", "contact_email", "company_location", "company_brands", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "company_name"
          },
          {
            data: "contact_person"
          },
          {
            data: "contact_phone"
          },
          {
            data: "contact_email"
          },
          {
            data: "company_location"
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
          width: 200,
          orderable: !1,
          render: function ( a, t, e, n )
          {
            var editING = BASE_URL + '/edit-ing/' + e.RecordID;

            return `<a href="javascript::void(0)" onclick="viewIngDetails(${ e.RecordID })"  class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="fa flaticon-eye"></i>
                  </a>
                  <a href="${ editING }"   class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="fa flaticon-edit"></i>
                  </a>
                  <a href="javascript::void(0)" onclick="deleteIngDetails(${ e.RecordID })"   class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                  <i class="fa flaticon-delete"></i>
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


// ingredent list
function deleteIngDetails( rowID )
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
        url: BASE_URL + "/deleteING",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), rowid: rowID },
        success: function ( resp )
        {
          console.log( resp );
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
            swal( "Deleted!", "Successfully Deleted", "success" ).then( function ( eyz )
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
function viewIngDetails( rowID )
{
  //ajcode
  //ajax call
  var HTML = "";
  var formData = {
    'rowid': rowID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getIngredentListID',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      console.log( res.link_brands );
      $( '.viewDetailsING' ).html( "" );

      HTML += `<div class="m-section">
										
       <div class="m-section__content">
         <table class="table">
         
           <tbody>
             <tr>														
               <td><b>Name:</b></td>
               <td>${ res.company_name }</td>															
             </tr>
             <tr>														
             <td><b>Address:</b></td>
             <td>${ res.full_address }</td>															
           </tr>														
           </tbody>
         </table>
       </div>
     </div>

     <!--end::Section-->
<div class="m-section">          
<div class="m-section__content">
<table class="table table-sm m-table m-table--head-bg-brand">
<thead class="thead-inverse">
 <tr>  
   <th>Name</th>
   <th>Phone</th>
   <th>Email</th>
 </tr>
</thead>
<tbody>`;
      $.each( res.contact_details, function ( index, value )
      {

        HTML += `<tr>  
  <td>${ value.contact_name }</td>
  <td>${ value.contact_phone }</td>
  <td>${ value.contact_email }</td>
</tr>`;

      } );

      HTML += `</tbody>
  </table>
</div>
</div>
<div class="m-section">          
<div class="m-section__content">
<table class="table table-sm m-table m-table--head-bg-secondary">
<thead class="thead-inverse">
 <tr>  
   <th>Brand ID</th>
   <th>Brand Name</th>
   
 </tr>
</thead>
<tbody>`;
      $.each( res.link_brands, function ( index, value )
      {


        HTML += `<tr>  
  <td>${ value.brand_id }</td>
  <td>${ value.brand_name }</td>
  
  
</tr>`;

      } );

      HTML += `</tbody>
  </table>
</div>
</div>
`;

      $( '.viewDetailsING' ).append( HTML );

      $( '#m_modal_4ING_DETAIL' ).modal( 'show' )
    },
    dataType: 'json'
  } );

  //ajax call
  //ajcode
}

//tblTeamMember
var DatatablesSalesDashTeamViews = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;


      a = $( "#tblTeamMember" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getTeamMember',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "teamcode", "teams", "userIMP", "user_name", "managerName", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),

          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "teamcode"
          },
          {
            data: "user_name"
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
              var ajID = "aj" + e.RecordID;

              return `<a href="javascript::void(0)" id="${ ajID }"  data-option="21"  onclick="addNewTeamMember_Mode(${ e.RecordID })" title="Add New Member" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="la la-plus"></i>
            </a>
            <a href="javascript::void(0)" id="${ ajID }"  data-option="21"  onclick="moveMembertoManagerTeam_Mode(${ e.RecordID })" title="Move Member to Another Team" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="fa fa-share"></i>
            </a>`

            }
          },
          {
            targets: [ 0 ],
            visible: !1
          },
          {
            targets: 2,
            title: "Members",
            render: function ( a, t, e, n )
            {
              var HTML = "";
              HTML += `<div class="m-list-pics m-list-pics--l m--padding-left-10" style ="backgroud-color:#CCCC">
              <a href="#">
              <img style="border:1px solid #ccc" src="${ e.userIMP }" title="${ e.user_name }"></a>
              `;
              $.each( e.teams, function ( index, objVal )
              {
                HTML += `
              <img style="border:1px  " width="35px" src="${ objVal.user_photo }" title="${ objVal.user_name }"></a>
              `
              } );


              HTML += `
              </div>`

              return HTML;


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
//tblTeamMember
//chooseS_status
$( 'input[name="choose_status"]' ).click( function ()
{
  if ( $( this ).prop( "checked" ) == true )
  {
    var action_status = $( this ).val();
    // ajax
    $( "#m_table_SampletList_technicaldoc" ).dataTable().fnDestroy()


    var a;
    var sample_action = $( '#txtSampleAction' ).val();

    a = $( "#m_table_SampletList_technicaldoc" ).DataTable( {
      // responsive: !0,
      // scrollY: "50vh",
      scrollX: !0,
      scrollCollapse: !0,

      lengthMenu: [ 5, 10, 25, 50, 5000 ],
      pageLength: 10,
      language: {
        lengthMenu: "Display _MENU_"
      },
      searchDelay: 500,
      processing: !0,
      serverSide: !0,
      ajax: {

        url: BASE_URL + '/getSamplesListTechnicaldata',
        type: "POST",
        data: {
          columnsDef: [ "RecordID", "status_data", "sample_created_by", "ingredent_data", "doc_name", "imgStatus", "sample_code", "item_name", "s_created_at", "created_on", "created_by", "item_requirement", "Actions" ],
          '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
          'action_status': action_status
        }
      },
      columns: [
        {
          data: "RecordID"
        },
        {
          data: "s_created_at"
        },
        {
          data: "sample_code"
        },
        {
          data: "item_name"
        },
        {
          data: "item_requirement"
        },
        {
          data: "created_by"
        },
        {
          data: "status_data"
        },
        {
          data: "created_on"
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
            var ingStatue = "";
            if ( e.ingredent_data === "NULL" || e.ingredent_data === "" || e.ingredent_data === null )
            {
              ingStatue = "";
            } else
            {

              ingStatue = "";
            }
            if ( UID == 1 || UID == 158 || UID == 124 || UID == 172 )
            {
              return `<a href="javascript::void(0)" onclick="add_feedback_sampleTechFile(${ e.RecordID },${ e.item_requirement })"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                <span>
                  <i class="la la-plus"></i>
                  <span>Doc</span>
                </span>
              </a>
              <a href="javascript::void(0)" onclick="add_feedback_sampleTech(${ e.RecordID })"  class="btn btn-primary m-btn btn-sm 	m-btn m-btn--icon">
                <span>
                  <i class="flaticon-arrows"></i>
                  <span>Link</span>
                </span>
              </a>
              <a title="view Sample Details" href="javascript::void(0)" onclick="view_sample_tech_details(${ e.RecordID })"  class="btn btn-success m-btn btn-sm 	m-btn m-btn--icon">
                    <span>
                      <i class="flaticon-eye"></i>
                     
                    </span>
                  </a>
                  ${ e.sample_created_by }
  
              ${ ingStatue }
  
              `
            } else
            {

              if ( e.item_requirement == 1 )
              {
                if ( e.ingredent_data === null )
                {
                  return ` <a href="javascript::void()" onclick="sfotDeleteOrderTechDoc(${ e.RecordID })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-trash"></i>
                      </a>
                      `
                } else
                {
                  return ` 
                      <a title="view Sample Details" href="javascript::void(0)" onclick="view_sample_tech_details(${ e.RecordID })"  class="btn btn-success m-btn btn-sm 	m-btn m-btn--icon">
                      <span>
                        <i class="flaticon-eye"></i>
                       
                      </span>
                    </a>
      
                      `
                }
              } else
              {


                if ( e.imgStatus != 1 )
                {
                  return ` <a href="javascript::void()" onclick="sfotDeleteOrderTechDoc(${ e.RecordID })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a>
                    
    
                    `
                } else
                {
                  return `<a title="view Sample Details" href="javascript::void(0)" onclick="view_sample_tech_details(${ e.RecordID })"  class="btn btn-success m-btn btn-sm 	m-btn m-btn--icon">
                      <span>
                        <i class="flaticon-eye"></i>                     
                      </span>
                    </a>`
                }


              }



            }

          }
        },
        {
          targets: 4,
          title: "Requirement DOC",
          orderable: !1,
          render: function ( a, t, e, n )
          {

            switch ( e.item_requirement )
            {
              case 1:
                // code block
                var strREQ = "Ingredient";
                break;
              case 2:
                // code block
                var strREQ = "COA";
                break;
              case 3:
                // code block
                var strREQ = "MSDS";
                break;

              // code block
            }
            if ( e.imgStatus == 1 )
            {
              return `${ strREQ.toUpperCase() } <br><a target="_blank"  href="${ e.doc_name }" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill">
                  <i class="fa fa-file-pdf"></i>
                </a>
                
                `


            } else
            {
              return strREQ.toUpperCase();
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


    // ajax
  }
  else if ( $( this ).prop( "checked" ) == false )
  {
    console.log( "Checkbox is unchecked." );
  }
} );

//chooseS_status
//m_table_OrderList_technicaldoc
var DatatablesSalesDashOrderDataList_technicalDocuement = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {

      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_OrderList_technicaldoc" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getordersListTechnicaldata',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", 'order_id', 'form_id', "status_data", "sample_created_by", "ingredent_data", "doc_name", "imgStatus", "sample_code", "item_name", "s_created_at", "created_on", "created_by", "item_requirement", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "s_created_at"
          },
          {
            data: "order_id"
          },
          {
            data: "item_name"
          },
          {
            data: "item_requirement"
          },
          {
            data: "created_by"
          },
          {
            data: "status_data"
          },
          {
            data: "created_on"
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
              if ( UID == 1 || UID == 158 || UID == 124 || UID == 172 || UID == 89 )
              {
                return `<a href="javascript::void(0)" onclick="add_feedback_sampleTechFileOrder(${ e.RecordID },${ e.item_requirement })"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                <span>
                  <i class="la la-plus"></i>
                  <span>Doc</span>
                </span>
              </a>`;
              } else
              {
                return ` 
                    <a title="view Sample Details" href="javascript::void(0)" onclick="view_sample_tech_details7(${ e.RecordID })"  class="btn btn-success m-btn btn-sm 	m-btn m-btn--icon">
                    <span>
                      <i class="flaticon-eye"></i>
                     
                    </span>`;
              }

            }
          },
          {
            targets: 4,
            title: "Requirement DOC",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              switch ( e.item_requirement )
              {

                case 1:
                  // code block
                  var strREQ = "COA";
                  break;
                case 2:
                  // code block
                  var strREQ = "MSDS";
                  break;
                case 3:
                  // code block
                  var strREQ = "STABILITY REPORT";
                  break;

                // code block
              }
              if ( e.imgStatus == 1 )
              {
                return `${ strREQ.toUpperCase() } <br><a target="_blank"  href="${ e.doc_name }" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill">
                <i class="fa fa-file-pdf"></i>
              </a>
              
              `


              } else
              {
                return strREQ.toUpperCase();
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

//m_table_OrderList_technicaldoc
//m_table_SampletList_technicaldoc

var DatatablesSalesDashSampleDataList_technicalDocuement = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {

      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_SampletList_technicaldoc" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getSamplesListTechnicaldata',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "status_data", "sample_created_by", "ingredent_data", "doc_name", "imgStatus", "sample_code", "item_name", "s_created_at", "created_on", "created_by", "item_requirement", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "s_created_at"
          },
          {
            data: "sample_code"
          },
          {
            data: "item_name"
          },
          {
            data: "item_requirement"
          },
          {
            data: "created_by"
          },
          {
            data: "status_data"
          },
          {
            data: "created_on"
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
              var ingStatue = "";
              if ( e.ingredent_data === "NULL" || e.ingredent_data === "" || e.ingredent_data === null )
              {
                ingStatue = "";
              } else
              {

                ingStatue = "";
              }
              if ( UID == 1 || UID == 158 || UID == 124 || UID == 172 || UID == 89 )
              {
                return `<a href="javascript::void(0)" onclick="add_feedback_sampleTechFile(${ e.RecordID },${ e.item_requirement })"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
              <span>
                <i class="la la-plus"></i>
                <span>Doc</span>
              </span>
            </a>
            <a href="javascript::void(0)" onclick="add_feedback_sampleTech(${ e.RecordID })"  class="btn btn-primary m-btn btn-sm 	m-btn m-btn--icon">
              <span>
                <i class="flaticon-arrows"></i>
                <span>Link</span>
              </span>
            </a>
            <a title="view Sample Details" href="javascript::void(0)" onclick="view_sample_tech_details(${ e.RecordID })"  class="btn btn-success m-btn btn-sm 	m-btn m-btn--icon">
                  <span>
                    <i class="flaticon-eye"></i>
                   
                  </span>
                </a>
                ${ e.sample_created_by }

            ${ ingStatue }

            `
              } else
              {

                if ( e.item_requirement == 1 )
                {
                  if ( e.ingredent_data === null )
                  {
                    return ` <a href="javascript::void()" onclick="sfotDeleteOrderTechDoc(${ e.RecordID })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a>
                    `
                  } else
                  {
                    return ` 
                    <a title="view Sample Details" href="javascript::void(0)" onclick="view_sample_tech_details(${ e.RecordID })"  class="btn btn-success m-btn btn-sm 	m-btn m-btn--icon">
                    <span>
                      <i class="flaticon-eye"></i>
                     
                    </span>
                  </a>
    
                    `
                  }
                } else
                {


                  if ( e.imgStatus != 1 )
                  {
                    return ` <a href="javascript::void()" onclick="sfotDeleteOrderTechDoc(${ e.RecordID })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-trash"></i>
                  </a>
                  
  
                  `
                  } else
                  {
                    return `<a title="view Sample Details" href="javascript::void(0)" onclick="view_sample_tech_details(${ e.RecordID })"  class="btn btn-success m-btn btn-sm 	m-btn m-btn--icon">
                    <span>
                      <i class="flaticon-eye"></i>                     
                    </span>
                  </a>`
                  }


                }



              }

            }
          },
          {
            targets: 4,
            title: "Requirement DOC",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              switch ( e.item_requirement )
              {
                case 1:
                  // code block
                  var strREQ = "Ingredient";
                  break;
                case 2:
                  // code block
                  var strREQ = "COA";
                  break;
                case 3:
                  // code block
                  var strREQ = "MSDS";
                  break;

                // code block
              }
              if ( e.imgStatus == 1 )
              {
                return `${ strREQ.toUpperCase() } <br><a target="_blank"  href="${ e.doc_name }" class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill">
                <i class="fa fa-file-pdf"></i>
              </a>
              
              `


              } else
              {
                return strREQ.toUpperCase();
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

//m_table_SampletList_technicaldoc

//m_table_SampletList_PendingApproval
var DatatablesSalesDashSampleDataListPendingAprroval = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_SampletList_PendingApproval" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getSamplesListPendingAprroval',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "sid", "sample_id", "sample_code", "item_name", "client_brand", "agent", "created_at", "feedback", "status", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sample_code"
          },
          {
            data: "item_name"
          },
          {
            data: "client_brand"
          },
          {
            data: "agent"
          },
          {
            data: "created_at"
          },
          {
            data: "feedback"
          },

          {
            data: "status"
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
        columnDefs: [
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {
              return `<a href="javascript::void(0)" onclick="add_technical_approval_with_price(${ e.RecordID })"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
              <span>
                <i class="la la-plus"></i>
                <span>Submit</span>
              </span>
            </a>`
            }
          },
          {
            targets: 6,
            title: "Feedback",
            orderable: !1,
            render: function ( a, t, e, n )
            {
              if ( e.feedback === null )
              {
                return `NA`;

              } else
              {
                return `<a href="javascript::void(0)" onclick="view_technical_feedback(${ e.sid })"  title="View Details of Sample Feedback" class="btn btn-outline-warning m-btn m-btn--icon m-btn--icon-only m-btn--pill">
                <i class="fa flaticon-eye"></i>
              </a>`
              }

            }
          },
          {
            targets: 7,
            title: "Feedback",
            orderable: !1,
            render: function ( a, t, e, n )
            {
              if ( e.status == 1 )
              {
                return '<b>APPROVED</b>';
              } else
              {
                return 'PENDING';
              }
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

//m_table_SampletList_PendingApproval

//salesdash
//datagrid Client list
var DatatablesSalesDashSampleDataList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_SampletList_SALESDASH" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getSamplesListSalesDash',
          type: "GET",
          data: {
            columnsDef: [ "is_rejected",'is_paid_status', 'isEncrypt', "RecordID", "assignedTo", "chkHandedOver", "sample_stage_id", "process_status", "edit_right", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sample_code"
          },
          {
            data: "company"
          },
          {
            data: "phone"
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
            data: "sample_stage_id"
          },
          {
            data: "order_status"
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
        columnDefs: [
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              //edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
              edit_URL = BASE_URL + '/sample/' + e.isEncrypt + '/edit';

              print_URL = BASE_URL + '/sample/print/' + e.RecordID;

              view_URL = BASE_URL + '/sample/' + e.RecordID + '';

              edit_URL = "#";//temp
              if ( _UNIB_RIGHT == 'SalesHead' )
              {
                var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          `;
                if ( e.created_by == 'Pooja Gupta' )
                {
                  if ( e.edit_right == 1 )
                  {
                    html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-edit"></i>
                    </a> `;
                  }

                  if ( e.Status == 2 )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                                title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                           <i class="flaticon-reply"></i>
                                                           </a>`;
                  } else
                  {
                    if ( e.Status == 1 )
                    {
                      if ( e.assignedTo !== null && e.assignedTo !== undefined )
                      {

                      } else
                      {
                        html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                        title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                   <i class="la la-trash"></i>
                                                   </a>`;
                      }

                    }
                    if ( e.sent_access )
                    {
                      html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                   title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                              <i class="flaticon-paper-plane-1"></i>
                                                              </a>`;
                    }
                  }


                }


              } else
              {

               
                
                var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          `;
                if ( e.is_paid_status == 1 )
                {
                  html += ` <a href="javascript::void(0)" onclick="add_payment_sample(${ e.RecordID })"  title="Uplaod Payment for Sample Approval" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                              <i class="fa fa-rupee-sign"></i>
                              </a>`;
                }


                if ( e.edit_right == 1 )
                {
                  html += ` <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                              </a>`;
                }

              
                if ( e.Status == 2 )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                                title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                           <i class="flaticon-reply"></i>
                                                           </a>`;
                } else
                {
                  if ( e.Status = 1 )
                  {
                    if ( e.assignedTo !== null && e.assignedTo !== undefined )
                    {

                    } else
                    {

                      html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                      title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                 <i class="la la-trash"></i>
                                                 </a>`;
                    }


                  }
                  if ( e.sent_access )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                   title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                              <i class=" flaticon-eye "></i>
                                                              </a>`;
                  }
                  if ( e.chkHandedOver )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                   title="Dispatch Sample" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                              <i class="flaticon-paper-plane-1"></i>
                                                              </a>`;
                  }
                }
              }


              if ( e.assignedTo !== null && e.assignedTo !== undefined )
              {
                var AssName = "<br>" + e.assignedTo;
              } else
              {
                var AssName = "";
              }


              if ( e.is_rejected == 1 )
              {

                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                   title="View Alert" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                              <i class="flaticon-bell"></i>
                                                              </a> <a style="margin-top:2px;" href="javascript::void(0)" onclick="sampleResubmit(${ e.RecordID })"
                                   title="Re-Submit" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                   <i class="flaticon-reply"></i>
                                                              </a>

                                                              `;


              }



              return html + AssName;
            }
          },
          {
            targets: 3,
            render: function ( a, t, e, n )
            {
              if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
              {
                return e.phone;
              } else
              {
                return '';
              }

            }
          },
          {
            targets: 7,
            render: function ( a, t, e, n )
            {
              var pid = 6;
              var i = {
                1: {
                  title: "NEW",
                  class: "m-badge--brand"
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
                  title: "DISPATCH",
                  class: " m-badge--secondary"
                }

              };
              return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(' + pid + ',' + e.RecordID + ')" <span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
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

//m_table_SampletList_LITE_HISTORY
var DatatablesSearchOptionsAdvancedSearchSampleDataList_LITE_HISTORY = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();


      a = $( "#m_table_SampletList_LITE_HISTORY" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getSamplesList_LITE_HISTORY',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "sample_assignedTo", "sample_stage_id", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sample_code"
          },
          {
            data: "company"
          },
          {
            data: "phone"
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
        columnDefs: [
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {


              edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
              print_URL = BASE_URL + '/sample/print/' + e.RecordID;

              view_URL = BASE_URL + '/sample/' + e.RecordID + '';

              if ( UID == 146 || UID == 189 )
              {


                if ( e.Status == 2 )
                {
                  var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                <a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample_AssingnTrackID(${ e.RecordID })"
  title="Update tracking Number" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
               <i class="flaticon-plus"></i>
               </a>
  
                `;
                  return html;
                } else
                {
                  var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                
  
                `;
                  return html;
                }
              }

              if ( UID == 124 )
              {
                var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>
                `;

                if ( e.Status == 2 )
                {

                } else
                {
                  if ( e.Status == 1 )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
      title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                 <i class="la la-trash"></i>
                                 </a>`;
                  }
                  if ( e.sent_access )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                     title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                <i class="flaticon-paper-plane-1"></i>
                                                </a>
                                                <a style="margin-top:2px;" href="javascript::void(0)" onclick="startSampleProvess(${ e.RecordID })"
                     title="Process Action" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="fa fa-check-circle"></i>
                                                </a>
                                                `;
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample_Assingn(${ e.RecordID })"
title="ASSIGN SAMPLE" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
             <i class="flaticon-plus"></i>
             </a>`;

                  }
                }
                return html + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;

              }


            }
          },
          {
            targets: 3,
            render: function ( a, t, e, n )
            {
              if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
              {
                return e.phone;
              } else
              {
                return '';
              }

            }
          },
          {
            targets: 7,
            render: function ( a, t, e, n )
            {

              var pid = 6;
              var stargeName = "";
              switch ( e.sample_stage_id )
              {
                case 1:
                  stargeName = "NEW";
                  break;
                case 2:
                  stargeName = "APPROVED";
                  break;
                case 3:
                  stargeName = "FORMULATIONS";
                  break;
                case 4:
                  stargeName = "PACKING";
                  break;
                case 5:
                  stargeName = "DISPATCH";
                  break;
              }
              if ( UID == 1894 || UID == 1467 )
              {
                return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                  
                ${ stargeName }
             
            </a>`;
              } else
              {
                return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLINGAA(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                  
                ${ stargeName }
             
            </a>`;
              }



              var i = {
                1: {
                  title: "NEW",
                  class: "m-badge--brand"
                },
                2: {
                  title: "SENT",
                  class: " m-badge--metal"
                },
                3: {
                  title: "RECIEVED",
                  class: " m-badge--primary"
                },
                4: {
                  title: "FEEDBACK",
                  class: " m-badge--success"
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

//m_table_SampletList_LITE_HISTORY
$( '#txtSample_Fragrance' ).on( 'change', function ()
{
  var selectedVal = $( this ).val();

  if ( selectedVal == 'Other' )
  {


    var otherFragrance = prompt( "Please Enter Other Fragrance" );

    var optionText = `<option selected value="${ otherFragrance.toUpperCase() }">${ otherFragrance.toUpperCase() }</option>`
    $( '#txtSample_Fragrance' ).append( `${ optionText }` )




  }
} );



//m_table_SampletList_LITE_COSMATIC_oilView

var DatatablesSearchOptionsAdvancedSearchSampleDataList_LITE_COSMATIC_oilView = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {

      var a;
      var sample_action = $( '#txtSampleAction' ).val();


      a = $( "#m_table_SampletList_LITE_COSMATIC_oilView" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getSamplesList_LITE_COSMATIC_viewAfterFormulation',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "sample_type", "sample_catType", "sample_assignedTo", "sample_stage_id", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', 'is_domestic', "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sample_code"
          },
          {
            data: "company"
          },
          {
            data: "phone"
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
            data: "Status"
          },
          {
            data: "sample_catType"
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
        columnDefs: [
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {


              edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
              print_URL = BASE_URL + '/sample/print/' + e.RecordID;

              view_URL = BASE_URL + '/sample/' + e.RecordID + '';
              if ( UID == 146 )
              {
                var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="la la-info"></i>
              </a>
              `;
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
              title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                         <i class="flaticon-paper-plane-1"></i>
                                         </a>`;

                return html;

              }

              if ( _UNIB_RIGHT == 'SalesHead' )
              {
                var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          `;
                if ( e.created_by == 'Pooja Gupta' )
                {
                  html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                              </a> `;
                  if ( e.Status == 2 )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                                title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                           <i class="flaticon-reply"></i>
                                                           </a>`;
                  } else
                  {
                    if ( e.Status == 1 )
                    {
                      html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                                  title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                             <i class="la la-trash"></i>
                                                             </a>`;
                    }
                    if ( e.sent_access )
                    {
                      html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                   title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                              <i class="flaticon-paper-plane-1"></i>
                                                              </a>`;
                    }
                  }


                }


              } else
              {

                var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                         `;
                if ( e.Status == 2 )
                {

                } else
                {
                  if ( e.Status == 1 )
                  {

                  }
                  if ( e.sent_access )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                   title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                              <i class="flaticon-paper-plane-1"></i>
                                                              </a>
                                                              <a style="margin-top:2px;" href="javascript::void(0)" onclick="startSampleProvess(${ e.RecordID })"
                                   title="Process Action" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                                   <i class="fa fa-check-circle"></i>
                                                              </a>
                                                              `;
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample_Assingn(${ e.RecordID })"
title="ASSIGN SAMPLE" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                           <i class="flaticon-plus"></i>
                           </a>`;

                  }
                }
              }



              if ( e.sample_assignedTo == "" )
              {
                return html;

              } else
              {
                // return html+"<br><b>Assign To:</b><br>"+e.sample_assignedTo;
                return html;

              }



            }
          },
          {
            targets: 3,
            render: function ( a, t, e, n )
            {
              if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
              {
                return e.phone;
              } else
              {
                if ( e.is_domestic == 2 )
                {
                  return `<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">INTERNATIONAL</span>`
                } else
                {
                  return '';
                }
              }

            }
          },
          {
            targets: 7,
            render: function ( a, t, e, n )
            {
              // if ( e.sample_assignedTo == "" )
              // {
              //   return `<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">NEW</span>`
              // } else
              // {

              // }
              var pid = 6;
              var stargeName = "";
              switch ( e.sample_stage_id )
              {
                case 1:
                  stargeName = "NEW";
                  break;
                case 2:
                  stargeName = "APPROVED";
                  break;
                case 3:
                  stargeName = "FORMULATION";
                  break;
                case 4:
                  stargeName = "PACKING";
                  break;
                case 5:
                  stargeName = "DISPATCH";
                  break;

                  return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                  
                  ${ stargeName }
               
              </a>`;

              }


              return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                  
              ${ stargeName }
           
          </a>`;




              var i = {
                1: {
                  title: "NEW",
                  class: "m-badge--brand"
                },
                2: {
                  title: "SENT",
                  class: " m-badge--metal"
                },
                3: {
                  title: "RECIEVED",
                  class: " m-badge--primary"
                },
                4: {
                  title: "FEEDBACK",
                  class: " m-badge--success"
                }

              };
              return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
            }
          },
          {
            targets: 8,
            render: function ( a, t, e, n )
            {
              switch ( e.sample_catType )
              {
                case 1:
                  textCat = "COSMETICS";
                  break;
                case 2:
                  textCat = "OILS";
                  break;
                case 3:
                  textCat = "GEN CHANGES";
                  break;
                case 4:
                  textCat = "BENCHMARK";
                  break;
                case 5:
                  textCat = "MODIFICATIONS";
                  break;
                default:
                  textCat = "";
              }
              if ( e.sample_assignedTo == "" )
              {
                return textCat;
              } else
              {
                return textCat + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
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

//m_table_SampletList_LITE_COSMATIC_oilView
//salesdash
//m_table_SampletList_LITE_COSMATIC
var DatatablesSearchOptionsAdvancedSearchSampleDataList_LITE_COSMATIC = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();


      a = $( "#m_table_SampletList_LITE_COSMATIC" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getSamplesList_LITE_COSMATIC',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "sample_type", "sample_catType", "sample_assignedTo", "sample_stage_id", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sample_code"
          },
          {
            data: "company"
          },
          {
            data: "phone"
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
            data: "sample_stage_id"
          },
          {
            data: "sample_catType"
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
        columnDefs: [
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
              print_URL = BASE_URL + '/sample/print/' + e.RecordID;

              view_URL = BASE_URL + '/sample/' + e.RecordID + '';

              if ( _UNIB_RIGHT == 'SalesHead' )
              {
                var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          `;
                if ( e.created_by == 'Pooja Gupta' )
                {
                  html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                              </a> `;
                  if ( e.Status == 2 )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                                title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                           <i class="flaticon-reply"></i>
                                                           </a>`;
                  } else
                  {
                    if ( e.Status == 1 )
                    {
                      html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                                  title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                             <i class="la la-trash"></i>
                                                             </a>`;
                    }
                    if ( e.sent_access )
                    {
                      html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                   title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                              <i class="flaticon-paper-plane-1"></i>
                                                              </a>`;
                    }
                  }


                }


              } else
              {

                var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                         `;
                if ( e.Status == 2 )
                {

                } else
                {
                  if ( e.Status == 1 )
                  {

                  }
                  if ( e.sent_access )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                   title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                              <i class="flaticon-paper-plane-1"></i>
                                                              </a>
                                                              <a style="margin-top:2px;" href="javascript::void(0)" onclick="startSampleProvess(${ e.RecordID })"
                                   title="Process Action" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                                   <i class="fa fa-check-circle"></i>
                                                              </a>
                                                              `;
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample_Assingn(${ e.RecordID })"
title="ASSIGN SAMPLE" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                           <i class="flaticon-plus"></i>
                           </a>`;

                  }
                }
              }



              if ( e.sample_assignedTo == "" )
              {
                return html;

              } else
              {
                // return html+"<br><b>Assign To:</b><br>"+e.sample_assignedTo;
                return html;

              }



            }
          },
          {
            targets: 3,
            render: function ( a, t, e, n )
            {
              if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
              {
                return e.phone;
              } else
              {
                return '';
              }

            }
          },
          {
            targets: 7,
            render: function ( a, t, e, n )
            {
              // if ( e.sample_assignedTo == "" )
              // {
              //   return `<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">NEW</span>`
              // } else
              // {

              // }
              var pid = 6;
              var stargeName = "";
              switch ( e.sample_stage_id )
              {
                case 1:
                  stargeName = "NEW";
                  break;
                case 2:
                  stargeName = "APPROVED";
                  break;
                case 3:
                  stargeName = "FORMULATION";
                  break;
                case 4:
                  stargeName = "PACKING";
                  break;
                case 5:
                  stargeName = "DISPATCH";
                  break;


                  return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                  
                  ${ stargeName }
               
              </a>`;

              }


              return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING_99(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                  
              ${ stargeName }
           
          </a>`;




              var i = {
                1: {
                  title: "NEW",
                  class: "m-badge--brand"
                },
                2: {
                  title: "SENT",
                  class: " m-badge--metal"
                },
                3: {
                  title: "RECIEVED",
                  class: " m-badge--primary"
                },
                4: {
                  title: "FEEDBACK",
                  class: " m-badge--success"
                }

              };
              return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
            }
          },
          {
            targets: 8,
            render: function ( a, t, e, n )
            {
              switch ( e.sample_catType )
              {
                case 1:
                  textCat = "COSMETICS";
                  break;
                case 2:
                  textCat = "OILS";
                  break;
                case 3:
                  textCat = "GEN CHANGES";
                  break;
                case 4:
                  textCat = "BENCHMARK";
                  break;
                case 5:
                  textCat = "MODIFICATIONS";
                  break;
                default:
                  textCat = "";
              }
              if ( e.sample_assignedTo == "" )
              {
                return textCat;
              } else
              {
                return textCat + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
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

//m_table_SampletList_LITE_COSMATIC

//m_table_SampletList_LITE_OILS
var DatatablesSearchOptionsAdvancedSearchSampleDataList_LITE_OILS = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();


      a = $( "#m_table_SampletList_LITE_OILS" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getSamplesList_LITE_OILS',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "sample_stage_id", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', 'is_domestic', "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sample_code"
          },
          {
            data: "company"
          },
          {
            data: "phone"
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
        columnDefs: [
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
              print_URL = BASE_URL + '/sample/print/' + e.RecordID;

              view_URL = BASE_URL + '/sample/' + e.RecordID + '';

              if ( _UNIB_RIGHT == 'SalesHead' )
              {
                var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          `;
                if ( e.created_by == 'Pooja Gupta' )
                {
                  html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                              </a> `;
                  if ( e.Status == 2 )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                                title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                           <i class="flaticon-reply"></i>
                                                           </a>`;
                  } else
                  {
                    if ( e.Status == 1 )
                    {
                      html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                                  title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                             <i class="la la-trash"></i>
                                                             </a>`;
                    }
                    if ( e.sent_access )
                    {
                      html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                   title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                              <i class="flaticon-paper-plane-1"></i>
                                                              </a>`;
                    }
                  }


                }


              } else
              {

                var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-eye"></i>
                          </a>
                          `;
                if ( e.Status == 2 )
                {

                } else
                {
                  if ( e.Status == 1 )
                  {

                  }
                  if ( e.sent_access )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                   title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                              <i class="flaticon-paper-plane-1"></i>
                                                              </a>
                                                              <a style="margin-top:2px;" href="javascript::void(0)" onclick="startSampleProvess(${ e.RecordID })"
                                   title="Process Action" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                                   <i class="fa fa-check-circle"></i>
                                                              </a>
                                                              `;
                  }
                }
              }





              return html;
            }
          },
          {
            targets: 3,
            render: function ( a, t, e, n )
            {
              if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
              {
                return e.phone;
              } else
              {
                if ( e.is_domestic == 2 )
                {
                  return `<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">INTERNATIONAL</span>`
                } else
                {
                  return '';
                }

              }

            }
          },
          {
            targets: 7,
            render: function ( a, t, e, n )
            {

              var pid = 6;
              var stargeName = "";
              switch ( e.sample_stage_id )
              {
                case 1:
                  stargeName = "NEW";
                  break;
                case 2:
                  stargeName = "APPROVED";
                  break;
                case 3:
                  stargeName = "FORMULATION";
                  break;
                case 4:
                  stargeName = "PACKING";
                  break;
                case 5:
                  stargeName = "DISPATCH";
                  break;


              }


              return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                  
    ${ stargeName }
 
</a>`;

              var i = {
                1: {
                  title: "NEW",
                  class: "m-badge--brand"
                },
                2: {
                  title: "SENT",
                  class: " m-badge--metal"
                },
                3: {
                  title: "RECIEVED",
                  class: " m-badge--primary"
                },
                4: {
                  title: "FEEDBACK",
                  class: " m-badge--success"
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

//m_table_SampletList_LITE_OILS
//m_table_SampletList_LITE
var DatatablesSearchOptionsAdvancedSearchSampleDataList_LITE = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();


      a = $( "#m_table_SampletList_LITE" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getSamplesList_LITE',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "sample_stage_id", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sample_code"
          },
          {
            data: "company"
          },
          {
            data: "phone"
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
        columnDefs: [
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
              print_URL = BASE_URL + '/sample/print/' + e.RecordID;

              view_URL = BASE_URL + '/sample/' + e.RecordID + '';

              if ( _UNIB_RIGHT == 'SalesHead' )
              {
                var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          `;
                if ( e.created_by == 'Pooja Gupta' )
                {
                  html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                              </a> `;
                  if ( e.Status == 2 )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                                title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                           <i class="flaticon-reply"></i>
                                                           </a>`;
                  } else
                  {
                    if ( e.Status == 1 )
                    {
                      html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                                  title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                             <i class="la la-trash"></i>
                                                             </a>`;
                    }
                    if ( e.sent_access )
                    {
                      html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                   title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                              <i class="flaticon-paper-plane-1"></i>
                                                              </a>`;
                    }
                  }


                }


              } else
              {

                var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                         `;
                if ( e.Status == 22 )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                                title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                           <i class="flaticon-reply"></i>
                                                           </a>`;
                } else
                {
                  if ( e.Status == 12 )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                                  title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                             <i class="la la-trash"></i>
                                                             </a>`;
                  }
                  if ( e.sent_access )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                   title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                              <i class="flaticon-paper-plane-1"></i>
                                                              </a>`;
                  }
                }
              }





              return html;
            }
          },
          {
            targets: 3,
            render: function ( a, t, e, n )
            {
              if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
              {
                return e.phone;
              } else
              {
                return '';
              }

            }
          },
          {
            targets: 7,
            render: function ( a, t, e, n )
            {

              var pid = 6;
              var stargeName = "";
              switch ( e.sample_stage_id )
              {
                case 1:
                  stargeName = "NEW";
                  break;
                case 2:
                  stargeName = "FORMULATION";
                  break;
                case 3:
                  stargeName = "PACKING";
                  break;
                case 4:
                  stargeName = "DISPATCH";
                  break;


              }


              return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                  
    ${ stargeName }
 
</a>`;

              var i = {
                1: {
                  title: "NEW",
                  class: "m-badge--brand"
                },
                2: {
                  title: "SENT",
                  class: " m-badge--metal"
                },
                3: {
                  title: "RECIEVED",
                  class: " m-badge--primary"
                },
                4: {
                  title: "FEEDBACK",
                  class: " m-badge--success"
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

//m_table_SampletList_FEEDBACKOWN
var DatatablesSearchOptionsAdvancedSearchSampleDataList_feedbackown = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_SampletList_FEEDBACKOWN" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getSamplesList_feedbac_own',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "sample_catType", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sample_code"
          },
          {
            data: "company"
          },
          {
            data: "phone"
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
            data: "Status"
          },
          {
            data: "order_status"
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
        columnDefs: [
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
              print_URL = BASE_URL + '/sample/print/' + e.RecordID;

              view_URL = BASE_URL + '/sample/' + e.RecordID + '';

              if ( _UNIB_RIGHT == 'SalesHead' )
              {
                var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
															<i class="la la-info"></i>
														</a>
                            `;
                if ( e.created_by == 'Pooja Gupta' )
                {
                  // html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  // 								<i class="la la-edit"></i>
                  //               </a> `;
                  if ( e.Status == 2 )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                                  title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                             <i class="flaticon-reply"></i>
                                                             </a>`;
                  } else
                  {
                    if ( e.Status == 1 )
                    {
                      // html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="Adelete_sample(${ e.RecordID })"
                      //               title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      //                                          <i class="la la-trash"></i>
                      //                                          </a>`;
                    }
                    if ( e.sent_access )
                    {
                      html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                     title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                <i class="flaticon-paper-plane-1"></i>
                                                                </a>`;
                    }
                  }


                }


              } else
              {

                var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
															<i class="la la-info"></i>
														</a>
                            `;
                if ( e.Status == 2 )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                                  title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                             <i class="flaticon-reply"></i>
                                                             </a>`;
                } else
                {
                  if ( e.Status == 1 )
                  {
                    // html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                    //                 title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    //                                            <i class="la la-trash"></i>
                    //                                            </a>`;
                  }
                  if ( e.sent_access )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                     title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                <i class="flaticon-paper-plane-1"></i>
                                                                </a>`;
                  }
                }
              }





              return html;
            }
          },
          {
            targets: 3,
            render: function ( a, t, e, n )
            {
              if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
              {
                return e.phone;
              } else
              {
                return '';
              }

            }
          },
          {
            targets: 8,
            render: function ( a, t, e, n )
            {
              switch ( e.sample_catType )
              {
                case 1:
                  textCat = "COSMATIC";
                  break;
                case 2:
                  textCat = "OILS";
                  break;
                default:
                  textCat = "";
              }

              return e.order_status + "<br>" + textCat;

            }
          },

          {
            targets: 7,
            render: function ( a, t, e, n )
            {
              var i = {
                1: {
                  title: "NEW",
                  class: "m-badge--brand"
                },
                2: {
                  title: "SENT",
                  class: " m-badge--metal"
                },
                3: {
                  title: "RECIEVED",
                  class: " m-badge--primary"
                },
                4: {
                  title: "FEEDBACK",
                  class: " m-badge--success"
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
//m_table_SampletList_FEEDBACKOWN


//unAssinedSampleList_Cosmatic
function unAssinedSampleList_Cosmatic()
{
  var a;
  $( "#m_table_SampletList_LITE_COSMATIC" ).dataTable().fnDestroy();


  var sample_action = $( '#txtSampleAction' ).val();


  a = $( "#m_table_SampletList_LITE_COSMATIC" ).DataTable( {
    // responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    scrollCollapse: !0,

    lengthMenu: [ 5, 10, 25, 50, 5000 ],
    pageLength: 10,
    language: {
      lengthMenu: "Display _MENU_"
    },
    searchDelay: 500,
    processing: !0,
    serverSide: !0,
    ajax: {

      url: BASE_URL + '/getSamplesList_LITE_COSMATIC_unassinedList',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "sample_type", "sample_catType", "sample_assignedTo", "sample_stage_id", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'sample_action': sample_action
      }
    },
    columns: [
      {
        data: "RecordID"
      },
      {
        data: "sample_code"
      },
      {
        data: "company"
      },
      {
        data: "phone"
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
        data: "Status"
      },
      {
        data: "sample_catType"
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
    columnDefs: [
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
          print_URL = BASE_URL + '/sample/print/' + e.RecordID;

          view_URL = BASE_URL + '/sample/' + e.RecordID + '';

          if ( _UNIB_RIGHT == 'SalesHead' )
          {
            var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-info"></i>
                      </a>
                      `;
            if ( e.created_by == 'Pooja Gupta' )
            {
              html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                          </a> `;
              if ( e.Status == 2 )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                            title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                       <i class="flaticon-reply"></i>
                                                       </a>`;
              } else
              {
                if ( e.Status == 1 )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                              title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                         <i class="la la-trash"></i>
                                                         </a>`;
                }
                if ( e.sent_access )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                               title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                          <i class="flaticon-paper-plane-1"></i>
                                                          </a>`;
                }
              }


            }


          } else
          {

            var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      `;
            if ( e.Status == 2 )
            {

            } else
            {
              if ( e.Status == 1 )
              {

              }
              if ( e.sent_access )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                               title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                          <i class="flaticon-paper-plane-1"></i>
                                                          </a>
                                                          <a style="margin-top:2px;" href="javascript::void(0)" onclick="startSampleProvess(${ e.RecordID })"
                               title="Process Action" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                               <i class="fa fa-check-circle"></i>
                                                          </a>
                                                          `;
                if ( e.sample_stage_id >= 2 )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample_Assingn(${ e.RecordID })"
                                                            title="ASSIGN SAMPLE" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                                   <i class="flaticon-plus"></i>
                                                                                   </a>`;
                }



              }
            }
          }



          if ( e.sample_assignedTo == "" )
          {
            return html;

          } else
          {
            return html + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
          }



        }
      },
      {
        targets: 3,
        render: function ( a, t, e, n )
        {
          if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
          {
            return e.phone;
          } else
          {
            return '';
          }

        }
      },
      {
        targets: 7,
        render: function ( a, t, e, n )
        {

          var pid = 6;
          var stargeName = "";
          switch ( e.sample_stage_id )
          {
            case 1:
              stargeName = "NEW";
              break;
            case 2:
              stargeName = "APPROVED";
              break;
            case 3:
              stargeName = "FORMULATION";
              break;
            case 4:
              stargeName = "PACKING";
              break;
            case 5:
              stargeName = "DISPATCH";
              break;


          }


          return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
              
${ stargeName }

</a>`;

          var i = {
            1: {
              title: "NEW",
              class: "m-badge--brand"
            },
            2: {
              title: "SENT",
              class: " m-badge--metal"
            },
            3: {
              title: "RECIEVED",
              class: " m-badge--primary"
            },
            4: {
              title: "FEEDBACK",
              class: " m-badge--success"
            }

          };
          return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
        }
      },
      {
        targets: 8,
        render: function ( a, t, e, n )
        {
          switch ( e.sample_catType )
          {
            case 1:
              textCat = "COSMETICS";
              break;
            case 2:
              textCat = "OILS";
              break;
            case 3:
              textCat = "GEN CHANGES";
              break;
            case 4:
              textCat = "BENCHMARK";
              break;
            case 5:
              textCat = "MODIFICATIONS";
              break;
            default:
              textCat = "";
          }
          if ( e.sample_assignedTo == "" )
          {
            return textCat;
          } else
          {
            return textCat + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
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
function AfterFormaulationSampleList__REFRESH()
{
  location.reload( 1 );
}

//unAssinedSampleList_Cosmatic
//AfterFormaulationSampleList__Cosmatic
function AfterFormaulationSampleList__Cosmatic()
{
  var a;
  $( "#m_table_SampletList_LITE_COSMATIC" ).dataTable().fnDestroy();


  var sample_action = $( '#txtSampleAction' ).val();


  a = $( "#m_table_SampletList_LITE_COSMATIC" ).DataTable( {
    // responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    scrollCollapse: !0,

    lengthMenu: [ 5, 10, 25, 50, 5000 ],
    pageLength: 10,
    language: {
      lengthMenu: "Display _MENU_"
    },
    searchDelay: 500,
    processing: !0,
    serverSide: !0,
    ajax: {

      url: BASE_URL + '/getSamplesList_LITE_COSMATIC_assinedListRESTALL',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "sample_type", "sample_catType", "sample_assignedTo", "sample_stage_id", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'sample_action': sample_action
      }
    },
    columns: [
      {
        data: "RecordID"
      },
      {
        data: "sample_code"
      },
      {
        data: "company"
      },
      {
        data: "phone"
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
        data: "sample_stage_id"
      },
      {
        data: "sample_catType"
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
    columnDefs: [
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
          print_URL = BASE_URL + '/sample/print/' + e.RecordID;

          view_URL = BASE_URL + '/sample/' + e.RecordID + '';

          if ( _UNIB_RIGHT == 'SalesHead' )
          {
            var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-info"></i>
                      </a>
                      `;
            if ( e.created_by == 'Pooja Gupta' )
            {
              html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                          </a> `;
              if ( e.Status == 2 )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                            title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                       <i class="flaticon-reply"></i>
                                                       </a>`;
              } else
              {
                if ( e.Status == 1 )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                              title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                         <i class="la la-trash"></i>
                                                         </a>`;
                }
                if ( e.sent_access )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                               title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                          <i class="flaticon-paper-plane-1"></i>
                                                          </a>`;
                }
              }


            }


          } else
          {

            var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      `;
            if ( e.Status == 2 )
            {

            } else
            {
              if ( e.Status == 1 )
              {

              }
              if ( e.sent_access )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                               title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                          <i class="flaticon-paper-plane-1"></i>
                                                          </a>
                                                          <a style="margin-top:2px;" href="javascript::void(0)" onclick="startSampleProvess(${ e.RecordID })"
                               title="Process Action" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                               <i class="fa fa-check-circle"></i>
                                                          </a>
                                                          `;
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample_Assingn(${ e.RecordID })"
title="ASSIGN SAMPLE" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                       <i class="flaticon-plus"></i>
                       </a>`;

              }
            }
          }



          if ( e.sample_assignedTo == "" )
          {
            return html;

          } else
          {
            //return html + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
            return html;

          }



        }
      },
      {
        targets: 3,
        render: function ( a, t, e, n )
        {
          if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
          {
            return e.phone;
          } else
          {
            return '';
          }

        }
      },
      {
        targets: 7,
        render: function ( a, t, e, n )
        {

          var pid = 6;
          var stargeName = "";
          switch ( e.sample_stage_id )
          {
            case 1:
              stargeName = "NEW";
              break;
            case 2:
              stargeName = "APPROVED";
              break;
            case 3:
              stargeName = "FORMULATION";
              break;
            case 4:
              stargeName = "PACKING";
              break;
            case 5:
              stargeName = "DISPATCH";
              break;


          }


          return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
              
${ stargeName }

</a>`;

          var i = {
            1: {
              title: "NEW",
              class: "m-badge--brand"
            },
            2: {
              title: "SENT",
              class: " m-badge--metal"
            },
            3: {
              title: "RECIEVED",
              class: " m-badge--primary"
            },
            4: {
              title: "FEEDBACK",
              class: " m-badge--success"
            }

          };
          return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
        }
      },
      {
        targets: 8,
        render: function ( a, t, e, n )
        {
          switch ( e.sample_catType )
          {
            case 1:
              textCat = "COSMETICS";
              break;
            case 2:
              textCat = "OILS";
              break;
            case 3:
              textCat = "GEN CHANGES";
              break;
            case 4:
              textCat = "BENCHMARK";
              break;
            case 5:
              textCat = "MODIFICATIONS";
              break;
            default:
              textCat = "";
          }
          if ( e.sample_assignedTo == "" )
          {
            return textCat;
          } else
          {
            return textCat + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
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

//AfterFormaulationSampleList__Cosmatic_Standard

function AfterFormaulationSampleList__Cosmatic_Standard()
{
  var a;
  $( "#m_table_SampletList_LITE_COSMATIC" ).dataTable().fnDestroy();


  var sample_action = $( '#txtSampleAction' ).val();


  a = $( "#m_table_SampletList_LITE_COSMATIC" ).DataTable( {
    // responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    scrollCollapse: !0,

    lengthMenu: [ 5, 10, 25, 50, 5000 ],
    pageLength: 10,
    language: {
      lengthMenu: "Display _MENU_"
    },
    searchDelay: 500,
    processing: !0,
    serverSide: !0,
    ajax: {

      url: BASE_URL + '/getSamplesList_LITE_COSMATIC_Standard',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "sample_type", "sample_catType", "sample_assignedTo", "sample_stage_id", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'sample_action': sample_action
      }
    },
    columns: [
      {
        data: "RecordID"
      },
      {
        data: "sample_code"
      },
      {
        data: "company"
      },
      {
        data: "phone"
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
        data: "Status"
      },
      {
        data: "sample_catType"
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
    columnDefs: [
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
          print_URL = BASE_URL + '/sample/print/' + e.RecordID;

          view_URL = BASE_URL + '/sample/' + e.RecordID + '';

          if ( _UNIB_RIGHT == 'SalesHead' )
          {
            var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-info"></i>
                      </a>
                      `;
            if ( e.created_by == 'Pooja Gupta' )
            {
              html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                          </a> `;
              if ( e.Status == 2 )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                            title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                       <i class="flaticon-reply"></i>
                                                       </a>`;
              } else
              {
                if ( e.Status == 1 )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                              title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                         <i class="la la-trash"></i>
                                                         </a>`;
                }
                if ( e.sent_access )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                               title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                          <i class="flaticon-paper-plane-1"></i>
                                                          </a>`;
                }
              }


            }


          } else
          {

            var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      `;
            if ( e.Status == 2 )
            {

            } else
            {
              if ( e.Status == 1 )
              {

              }
              if ( e.sent_access )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                               title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                          <i class="flaticon-paper-plane-1"></i>
                                                          </a>
                                                          <a style="margin-top:2px;" href="javascript::void(0)" onclick="startSampleProvess(${ e.RecordID })"
                               title="Process Action" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                               <i class="fa fa-check-circle"></i>
                                                          </a>
                                                          `;
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample_Assingn(${ e.RecordID })"
title="ASSIGN SAMPLE" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                       <i class="flaticon-plus"></i>
                       </a>`;

              }
            }
          }



          if ( e.sample_assignedTo == "" )
          {
            return html;

          } else
          {
            // return html + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
            return html;
          }



        }
      },
      {
        targets: 3,
        render: function ( a, t, e, n )
        {
          if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
          {
            return e.phone;
          } else
          {
            return '';
          }

        }
      },
      {
        targets: 7,
        render: function ( a, t, e, n )
        {

          var pid = 6;
          var stargeName = "";
          switch ( e.sample_stage_id )
          {
            case 1:
              stargeName = "NEW";
              break;
            case 2:
              stargeName = "APPROVED";
              break;
            case 3:
              stargeName = "FORMULATION";
              break;
            case 4:
              stargeName = "PACKING";
              break;
            case 5:
              stargeName = "DISPATCH";
              break;


          }


          return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
              
${ stargeName }

</a>`;

          var i = {
            1: {
              title: "NEW",
              class: "m-badge--brand"
            },
            2: {
              title: "SENT",
              class: " m-badge--metal"
            },
            3: {
              title: "RECIEVED",
              class: " m-badge--primary"
            },
            4: {
              title: "FEEDBACK",
              class: " m-badge--success"
            }

          };
          return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
        }
      },
      {
        targets: 8,
        render: function ( a, t, e, n )
        {
          switch ( e.sample_catType )
          {
            case 1:
              textCat = "COSMETICS";
              break;
            case 2:
              textCat = "OILS";
              break;
            case 3:
              textCat = "GEN CHANGES";
              break;
            case 4:
              textCat = "BENCHMARK";
              break;
            case 5:
              textCat = "MODIFICATIONS";
              break;
            default:
              textCat = "";
          }
          if ( e.sample_assignedTo == "" )
          {
            return textCat;
          } else
          {
            return textCat + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
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

//AfterFormaulationSampleList__Cosmatic_Standard

//AfterFormaulationSampleList__Cosmatic

// AssinedSampleList__Cosmatic
function AssinedSampleList__Cosmatic()
{
  var a;
  $( "#m_table_SampletList_LITE_COSMATIC" ).dataTable().fnDestroy();


  var sample_action = $( '#txtSampleAction' ).val();


  a = $( "#m_table_SampletList_LITE_COSMATIC" ).DataTable( {
    // responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    scrollCollapse: !0,

    lengthMenu: [ 5, 10, 25, 50, 5000 ],
    pageLength: 10,
    language: {
      lengthMenu: "Display _MENU_"
    },
    searchDelay: 500,
    processing: !0,
    serverSide: !0,
    ajax: {

      url: BASE_URL + '/getSamplesList_LITE_COSMATIC_assinedList',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "sample_type", "sample_catType", "sample_assignedTo", "sample_stage_id", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'sample_action': sample_action
      }
    },
    columns: [
      {
        data: "RecordID"
      },
      {
        data: "sample_code"
      },
      {
        data: "company"
      },
      {
        data: "phone"
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
        data: "sample_stage_id"
      },
      {
        data: "sample_catType"
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
    columnDefs: [
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
          print_URL = BASE_URL + '/sample/print/' + e.RecordID;

          view_URL = BASE_URL + '/sample/' + e.RecordID + '';

          if ( _UNIB_RIGHT == 'SalesHead' )
          {
            var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-info"></i>
                      </a>
                      `;
            if ( e.created_by == 'Pooja Gupta' )
            {
              html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-edit"></i>
                          </a> `;
              if ( e.Status == 2 )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                            title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                       <i class="flaticon-reply"></i>
                                                       </a>`;
              } else
              {
                if ( e.Status == 1 )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                              title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                         <i class="la la-trash"></i>
                                                         </a>`;
                }
                if ( e.sent_access )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                               title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                          <i class="flaticon-paper-plane-1"></i>
                                                          </a>`;
                }
              }


            }


          } else
          {

            var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a>
                      `;
            if ( e.Status == 2 )
            {

            } else
            {
              if ( e.Status == 1 )
              {

              }
              if ( e.sent_access )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                               title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                          <i class="flaticon-paper-plane-1"></i>
                                                          </a>
                                                          <a style="margin-top:2px;" href="javascript::void(0)" onclick="startSampleProvess(${ e.RecordID })"
                               title="Process Action" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                               <i class="fa fa-check-circle"></i>
                                                          </a>
                                                          `;
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample_Assingn(${ e.RecordID })"
title="ASSIGN SAMPLE" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                       <i class="flaticon-plus"></i>
                       </a>`;

              }
            }
          }



          if ( e.sample_assignedTo == "" )
          {
            return html;

          } else
          {
            // return html + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
            return html;
          }



        }
      },
      {
        targets: 3,
        render: function ( a, t, e, n )
        {
          if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
          {
            return e.phone;
          } else
          {
            return '';
          }

        }
      },
      {
        targets: 7,
        render: function ( a, t, e, n )
        {

          var pid = 6;
          var stargeName = "";
          switch ( e.sample_stage_id )
          {
            case 1:
              stargeName = "NEW";
              break;
            case 2:
              stargeName = "APPROVED";
              break;
            case 3:
              stargeName = "FORMULATION";
              break;
            case 4:
              stargeName = "PACKING";
              break;
            case 5:
              stargeName = "DISPATCH";
              break;



          }


          return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
              
${ stargeName }

</a>`;

          var i = {
            1: {
              title: "NEW",
              class: "m-badge--brand"
            },
            2: {
              title: "SENT",
              class: " m-badge--metal"
            },
            3: {
              title: "RECIEVED",
              class: " m-badge--primary"
            },
            4: {
              title: "FEEDBACK",
              class: " m-badge--success"
            }

          };
          return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
        }
      },
      {
        targets: 8,
        render: function ( a, t, e, n )
        {
          switch ( e.sample_catType )
          {
            case 1:
              textCat = "COSMETICS";
              break;
            case 2:
              textCat = "OILS";
              break;
            case 3:
              textCat = "GEN CHANGES";
              break;
            case 4:
              textCat = "BENCHMARK";
              break;
            case 5:
              textCat = "MODIFICATIONS";
              break;
            default:
              textCat = "";
          }
          if ( e.sample_assignedTo == "" )
          {
            return textCat;
          } else
          {
            return textCat + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
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

//AssinedSampleList__Cosmatic
//m_table_SampletList_LITE
//unAssinedSampleList_OIL_ONLY
function unAssinedSampleList_OIL_ONLY()
{
  var a;
  $( "#m_table_SampletList" ).dataTable().fnDestroy();


  var sample_action = $( '#txtSampleAction' ).val();

  a = $( "#m_table_SampletList" ).DataTable( {
    // responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    scrollCollapse: !0,

    lengthMenu: [ 5, 10, 25, 50, 5000 ],
    pageLength: 10,
    language: {
      lengthMenu: "Display _MENU_"
    },
    searchDelay: 500,
    processing: !0,
    serverSide: !0,
    ajax: {

      url: BASE_URL + '/getSamplesList_UnassignedList_OILS',
      type: "POST",
      data: {
        columnsDef: [ "is_rejected", "RecordID", "sample_assignedTo", "sample_stage_id", "edit_right", "sample_catType", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'sample_action': sample_action
      }
    },
    columns: [
      {
        data: "RecordID"
      },
      {
        data: "sample_code"
      },
      {
        data: "company"
      },
      {
        data: "phone"
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
        data: "sample_stage_id"
      },
      {
        data: "order_status"
      },
      {
        data: "sample_catType"
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
    columnDefs: [
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
          print_URL = BASE_URL + '/sample/print/' + e.RecordID;

          view_URL = BASE_URL + '/sample/' + e.RecordID + '';

          if ( _UNIB_RIGHT == 'SalesHead' )
          {
            var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-info"></i>
                        </a>
                        `;
            if ( e.created_by == 'Pooja Gupta' )
            {
              if ( e.edit_right == 1 )
              {
                html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="la la-edit"></i>
              </a> `;
              }


              if ( e.Status == 2 )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                              title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                         <i class="flaticon-reply"></i>
                                                         </a>`;
              } else
              {
                if ( e.Status == 1 )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                                title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                           <i class="la la-trash"></i>
                                                           </a>`;
                }
                if ( e.sent_access )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                 title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                            <i class="flaticon-paper-plane-1"></i>
                                                            </a>`;
                }
              }


            } else
            {
              if ( e.sample_stage_id == 1 )
              {
                html += `<a href="javascript::void(0)" onclick="wantToRejectorModifySample(${ e.RecordID })" title="Reject or Request for modification" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="fa fa-plus"></i>
                    </a>`;
              }
              if ( e.is_rejected == 0 )
              {
                html += `<a href="#" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="la la-check"></i>
                  </a>`;
              } else
              {
                html += `<a href="#" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill m-btn--air">
                    <i class="la la-trash"></i>
                  </a>`;
              }

            }


          } else
          {

            var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-info"></i>
                        </a>
                        `;
            if ( e.edit_right == 1 )
            {
              html += ` <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                              <i class="la la-edit"></i>
                            </a>`
            }
            if ( e.Status == 2 )
            {
              html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                              title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                         <i class="flaticon-reply"></i>
                                                         </a>`;
            } else
            {
              if ( e.Status == 1 )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                                title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                           <i class="la la-trash"></i>
                                                           </a>`;
              }
              if ( e.sent_access )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                 title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                            <i class="flaticon-paper-plane-1"></i>
                                                            </a>`;

                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample_Assingn(${ e.RecordID })"
                                 title="ASSIGN SAMPLE" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                            <i class="flaticon-plus"></i>
                                                            </a>`;
              }
            }
          }





          return html;
        }
      },
      {
        targets: 3,
        render: function ( a, t, e, n )
        {
          if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
          {
            return e.phone;
          } else
          {
            return '';
          }

        }
      },
      {
        targets: 8,
        render: function ( a, t, e, n )
        {


          return e.order_status;

        }
      },
      {
        targets: 9,
        render: function ( a, t, e, n )
        {
          switch ( e.sample_catType )
          {
            case 1:
              textCat = "COSMETICS";
              break;
            case 2:
              textCat = "OILS";
              break;
            case 3:
              textCat = "GEN CHANGES";
              break;
            case 4:
              textCat = "BENCHMARK";
              break;
            case 5:
              textCat = "MODIFICATIONS";
              break;
            default:
              textCat = "";
          }
          if ( e.sample_assignedTo == "" )
          {
            return textCat;
          } else
          {
            return textCat + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
          }


        }
      },


      {
        targets: 7,
        render: function ( a, t, e, n )
        {
          var pid = 6;
          var stargeName = "";
          switch ( e.sample_stage_id )
          {
            case 1:
              stargeName = "NEW";
              break;
            case 2:
              stargeName = "FORMULATION";
              break;
            case 3:
              stargeName = "PACKING";
              break;
            case 4:
              stargeName = "DISPATCH";
              break;


          }


          return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                            
              ${ stargeName }
           
          </a>`;

          var i = {
            1: {
              title: "NEW",
              class: "m-badge--brand"
            },
            2: {
              title: "SENT",
              class: "m-badge--metal"
            },
            3: {
              title: "RECIEVED",
              class: "m-badge--primary"
            },
            4: {
              title: "FEEDBACK",
              class: "m-badge--success"
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

//unAssinedSampleList_OIL_ONLY
//ajaxL


var DatatablesDataSourceAjaxServerFAQList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();

      a = $( "#m_table_FAQList" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getProductFAQ',
          type: "POST",
          data: {
            columnsDef: [ "created_at", "RecordID", "posts", "product_name", "created_by", "anscount", "is_answered", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "created_at"
          },
          {
            data: "posts"
          },
          {
            data: "product_name"
          },
          {
            data: "created_by"
          },
          {
            data: "anscount"
          },
          {
            data: "is_answered"
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
              return `<a title="View Question Detail and Answers" href="javascript::void(0)" onclick="view_QuestionsFAQ(${ e.RecordID })" class="btn btn-success m-btn btn-sm 	m-btn m-btn--icon">
              <span>
                <i class="flaticon-eye"></i>
               
              </span>
            </a>`

            }
          },
          {
            targets: 6,
            render: function ( a, t, e, n )
            {


              var i = {
                0: {
                  title: "Unanswered",
                  class: "m-badge--warning"
                },
                1: {
                  title: "Answered",
                  class: "m-badge--success"
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

//ajaxL


//unAssinedSampleList
function unAssinedSampleList()
{
  var a;
  $( "#m_table_SampletList" ).dataTable().fnDestroy();


  var sample_action = $( '#txtSampleAction' ).val();

  a = $( "#m_table_SampletList" ).DataTable( {
    // responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    scrollCollapse: !0,

    lengthMenu: [ 5, 10, 25, 50, 5000 ],
    pageLength: 10,
    language: {
      lengthMenu: "Display _MENU_"
    },
    searchDelay: 500,
    processing: !0,
    serverSide: !0,
    ajax: {

      url: BASE_URL + '/getSamplesList_UnassignedList',
      type: "POST",
      data: {
        columnsDef: [ "is_rejected", "RecordID", "sample_assignedTo", "sample_stage_id", "edit_right", "sample_catType", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'sample_action': sample_action
      }
    },
    columns: [
      {
        data: "RecordID"
      },
      {
        data: "sample_code"
      },
      {
        data: "company"
      },
      {
        data: "phone"
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
        data: "sample_stage_id"
      },
      {
        data: "order_status"
      },
      {
        data: "sample_catType"
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
    columnDefs: [
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
          print_URL = BASE_URL + '/sample/print/' + e.RecordID;

          view_URL = BASE_URL + '/sample/' + e.RecordID + '';

          if ( _UNIB_RIGHT == 'SalesHead' )
          {
            var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-info"></i>
                        </a>
                        `;
            if ( e.created_by == 'Pooja Gupta' )
            {
              if ( e.edit_right == 1 )
              {
                html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="la la-edit"></i>
              </a> `;
              }


              if ( e.Status == 2 )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                              title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                         <i class="flaticon-reply"></i>
                                                         </a>`;
              } else
              {
                if ( e.Status == 1 )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                                title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                           <i class="la la-trash"></i>
                                                           </a>`;
                }
                if ( e.sent_access )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                 title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                            <i class="flaticon-paper-plane-1"></i>
                                                            </a>`;
                }
              }


            } else
            {
              if ( e.sample_stage_id == 1 )
              {
                html += `<a href="javascript::void(0)" onclick="wantToRejectorModifySample(${ e.RecordID })" title="Reject or Request for modification" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="fa fa-plus"></i>
                    </a>`;
              }
              if ( e.is_rejected == 0 )
              {
                html += `<a href="#" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="la la-check"></i>
                  </a>`;
              } else
              {
                html += `<a href="#" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill m-btn--air">
                    <i class="la la-trash"></i>
                  </a>`;
              }

            }


          } else
          {

            var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-info"></i>
                        </a>
                        `;
            if ( e.edit_right == 1 )
            {
              html += ` <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                              <i class="la la-edit"></i>
                            </a>`
            }
            if ( e.Status == 2 )
            {
              html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                              title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                         <i class="flaticon-reply"></i>
                                                         </a>`;
            } else
            {
              if ( e.Status == 1 )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                                title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                           <i class="la la-trash"></i>
                                                           </a>`;
              }
              if ( e.sent_access )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                 title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                            <i class="flaticon-paper-plane-1"></i>
                                                            </a>`;

                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample_Assingn(${ e.RecordID })"
                                 title="ASSIGN SAMPLE" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                            <i class="flaticon-plus"></i>
                                                            </a>`;
              }
            }
          }





          return html;
        }
      },
      {
        targets: 3,
        render: function ( a, t, e, n )
        {
          if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
          {
            return e.phone;
          } else
          {
            return '';
          }

        }
      },
      {
        targets: 8,
        render: function ( a, t, e, n )
        {


          return e.order_status;

        }
      },
      {
        targets: 9,
        render: function ( a, t, e, n )
        {
          switch ( e.sample_catType )
          {
            case 1:
              textCat = "COSMETICS";
              break;
            case 2:
              textCat = "OILS";
              break;
            case 3:
              textCat = "GEN CHANGES";
              break;
            case 4:
              textCat = "BENCHMARK";
              break;
            case 5:
              textCat = "MODIFICATIONS";
              break;
            default:
              textCat = "";
          }
          if ( e.sample_assignedTo == "" )
          {
            return textCat;
          } else
          {
            return textCat + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
          }


        }
      },


      {
        targets: 7,
        render: function ( a, t, e, n )
        {
          var pid = 6;
          var stargeName = "";
          switch ( e.sample_stage_id )
          {
            case 1:
              stargeName = "NEW";
              break;
            case 2:
              stargeName = "FORMULATION";
              break;
            case 3:
              stargeName = "PACKING";
              break;
            case 4:
              stargeName = "DISPATCH";
              break;


          }


          return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                            
              ${ stargeName }
           
          </a>`;

          var i = {
            1: {
              title: "NEW",
              class: "m-badge--brand"
            },
            2: {
              title: "SENT",
              class: "m-badge--metal"
            },
            3: {
              title: "RECIEVED",
              class: "m-badge--primary"
            },
            4: {
              title: "FEEDBACK",
              class: "m-badge--success"
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
//unAssinedSampleList

//AssinedSampleList
function AssinedSampleList()
{

  var a;
  $( "#m_table_SampletList" ).dataTable().fnDestroy();


  var sample_action = $( '#txtSampleAction' ).val();

  a = $( "#m_table_SampletList" ).DataTable( {
    // responsive: !0,
    // scrollY: "50vh",
    scrollX: !0,
    scrollCollapse: !0,

    lengthMenu: [ 5, 10, 25, 50, 5000 ],
    pageLength: 10,
    language: {
      lengthMenu: "Display _MENU_"
    },
    searchDelay: 500,
    processing: !0,
    serverSide: !0,
    ajax: {

      url: BASE_URL + '/getSamplesList_assignedList',
      type: "POST",
      data: {
        columnsDef: [ "RecordID", "sample_assignedTo", "sample_stage_id", "edit_right", "sample_catType", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'sample_action': sample_action
      }
    },
    columns: [
      {
        data: "RecordID"
      },
      {
        data: "sample_code"
      },
      {
        data: "company"
      },
      {
        data: "phone"
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
        data: "sample_stage_id"
      },
      {
        data: "order_status"
      },
      {
        data: "sample_catType"
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
    columnDefs: [
      {
        targets: -1,
        title: "Actions",
        orderable: !1,
        render: function ( a, t, e, n )
        {

          edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
          print_URL = BASE_URL + '/sample/print/' + e.RecordID;

          view_URL = BASE_URL + '/sample/' + e.RecordID + '';

          if ( _UNIB_RIGHT == 'SalesHead' )
          {
            var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-info"></i>
                        </a>
                        `;
            if ( e.created_by == 'Pooja Gupta' )
            {
              if ( e.edit_right == 1 )
              {
                html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="la la-edit"></i>
              </a> `;
              }


              if ( e.Status == 2 )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                              title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                         <i class="flaticon-reply"></i>
                                                         </a>`;
              } else
              {
                if ( e.Status == 1 )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                                title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                           <i class="la la-trash"></i>
                                                           </a>`;
                }
                if ( e.sent_access )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                 title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                            <i class="flaticon-paper-plane-1"></i>
                                                            </a>`;
                }
              }


            }


          } else
          {

            var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-info"></i>
                        </a>
                        `;
            if ( e.edit_right == 1 )
            {
              html += ` <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                              <i class="la la-edit"></i>
                            </a>`
            }
            if ( e.Status == 2 )
            {
              html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                              title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                         <i class="flaticon-reply"></i>
                                                         </a>`;
            } else
            {
              if ( e.Status == 1 )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                                title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                           <i class="la la-trash"></i>
                                                           </a>`;
              }
              if ( e.sent_access )
              {
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                 title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                            <i class="flaticon-paper-plane-1"></i>
                                                            </a>`;

                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample_Assingn(${ e.RecordID })"
                                 title="ASSIGN SAMPLE" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                            <i class="flaticon-plus"></i>
                                                            </a>`;
              }
            }
          }





          return html;
        }
      },
      {
        targets: 3,
        render: function ( a, t, e, n )
        {
          if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == 'SalesUser' )
          {
            return e.phone;
          } else
          {
            return '';
          }

        }
      },
      {
        targets: 8,
        render: function ( a, t, e, n )
        {


          return e.order_status;

        }
      },
      {
        targets: 9,
        render: function ( a, t, e, n )
        {
          switch ( e.sample_catType )
          {
            case 1:
              textCat = "COSMETICS";
              break;
            case 2:
              textCat = "OILS";
              break;
            case 3:
              textCat = "GEN CHANGES";
              break;
            case 4:
              textCat = "BENCHMARK";
              break;
            case 5:
              textCat = "MODIFICATIONS";
              break;
            default:
              textCat = "";
          }
          if ( e.sample_assignedTo == "" )
          {
            return textCat;
          } else
          {
            return textCat + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
          }


        }
      },


      {
        targets: 7,
        render: function ( a, t, e, n )
        {
          var pid = 6;
          var stargeName = "";
          switch ( e.sample_stage_id )
          {
            case 1:
              stargeName = "NEW";
              break;
            case 2:
              stargeName = "APPROVED";
              break;
            case 3:
              stargeName = "FORMULATION";
              break;
            case 4:
              stargeName = "PACKING";
              break;
            case 4:
              stargeName = "DISPATCH";
              break;


          }


          return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                            
              ${ stargeName }
           
          </a>`;

          var i = {
            1: {
              title: "NEW",
              class: "m-badge--brand"
            },
            2: {
              title: "SENT",
              class: "m-badge--metal"
            },
            3: {
              title: "RECIEVED",
              class: "m-badge--primary"
            },
            4: {
              title: "FEEDBACK",
              class: "m-badge--success"
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
//AssinedSampleList

//datagrid Client list
var DatatablesSearchOptionsAdvancedSearchSampleDataList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();
      var sidStatus = $( '#sidStatus' ).val();
      

      var priority = $( '#priority' ).val();

      if ( priority == 1 )
      {
        var URL_SAM = BASE_URL + '/getSamplesListHigh';
      } else
      {
        if ( priority == 3 )
        {
          var URL_SAM = '';
        } else
        {
          var URL_SAM = BASE_URL + '/getSamplesList';
        }

      }

      a = $( "#m_table_SampletList" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: URL_SAM,
          type: "GET",
          data: {
            columnsDef: [ "admin_urgent_status", "brand_type", "order_size", "isEncrypt", "is_rejected", "RecordID", "formatation_status", "sample_assignedTo", "sample_stage_id", "edit_right", "sample_catType", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action,
            'sidStatus': sidStatus,

          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sample_code"
          },
          {
            data: "company"
          },
          {
            data: "brand_type"
          },
          {
            data: "order_size"
          },
          {
            data: "created_on"
          },
          {
            data: "created_by"
          },

          {
            data: "sample_stage_id"
          },
          {
            data: "order_status"
          },
          {
            data: "sample_catType"
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

              edit_URL = BASE_URL + '/sample/' + e.isEncrypt + '/edit';
              edit_URL = "#";
              print_URL = BASE_URL + '/sample/print/' + e.RecordID;

              view_URL = BASE_URL + '/sample/' + e.RecordID + '';
              if(UID==147){
                return '';
              }

              if ( _UNIB_RIGHT == 'SalesHead' )
              {
                var html = `<a target="_blank" href="${ view_URL }"  title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
															<i class="la la-info"></i>
														</a>

                            `;
                html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="set_samplePriority(${ e.RecordID })"
                            title="Set priority" class="btn btn-secondary m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="flaticon-bell" style="color:red"></i>
                                                       </a>`;


                if ( e.created_by == 'Pooja Gupta' )
                {
                  if ( e.edit_right == 1 )
                  {
                    html += `<a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-edit"></i>
                  </a> `;
                  }


                  if ( e.Status == 2 )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                                  title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                             <i class="flaticon-reply"></i>
                                                             </a>`;
                  } else
                  {
                    if ( e.Status == 1 )
                    {
                      html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                                    title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                               <i class="la la-trash"></i>
                                                               </a>`;
                    }
                    if ( e.sent_access )
                    {
                      html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                     title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                <i class="flaticon-paper-plane-1"></i>
                                                                </a>`;
                    }
                  }


                } else
                {
                  if ( e.sample_stage_id == 1 )
                  {
                    html += `<a href="javascript::void(0)" onclick="wantToRejectorModifySample(${ e.RecordID })" title="Reject or Request for modification" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="fa fa-plus"></i>
                    </a>`;
                  }
                  if ( e.is_rejected == 0 )
                  {
                    html += `<a href="#" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="la la-check"></i>
                  </a>`;
                  } else
                  {
                    html += `<a href="#" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only  m-btn--pill m-btn--air">
                    <i class="la la-trash"></i>
                  </a>`;
                  }




                }


              } else
              {

                edit_URL = BASE_URL + '/sample/' + e.isEncrypt + '/edit';

                var html = `<a target="_blank" href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
															<i class="la la-info"></i>
														</a>
                            `;
                if ( e.edit_right == 1 )
                {
                  html += ` <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
    															<i class="la la-edit"></i>
                                </a>`
                }
                if ( e.Status == 2 )
                {
                  html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="add_feedback_sample(${ e.RecordID })"
                                  title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                             <i class="flaticon-reply"></i>
                                                             </a>`;
                } else
                {
                  if ( e.Status == 1 )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="delete_sample(${ e.RecordID })"
                                    title="DELETE " class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                               <i class="la la-trash"></i>
                                                               </a>`;
                  }
                  if ( e.sent_access )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                     title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                <i class="flaticon-paper-plane-1"></i>
                                                                </a>`;

                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample_Assingn(${ e.RecordID })"
                                     title="ASSIGN SAMPLE" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                                <i class="flaticon-plus"></i>
                                                                </a>`;
                  }
                  //formatation_status
                  if ( e.formatation_status )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="view_sampleFormulation(${ e.RecordID })"
                                     title="VIEW Formulation" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                     <i class="flaticon-information"></i>
                                                                </a>`;

                  }
                  if ( UID == 1 || UID == 90 || UID == 171 )
                  {
                    html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="set_samplePriority(${ e.RecordID })"
                    title="Set priority" class="btn btn-secondary m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-bell" style="color:red"></i>
                                               </a>`;
                  }


                  //formatation_status
                }
              }





              return html;
            }
          },
          {
            targets: 3,
            render: function ( a, t, e, n )
            {
              var i = {
                1: {
                  title: "NEW BRAND",
                  class: "m-badge--brand"
                },
                2: {
                  title: "SMALL BRAND",
                  class: "m-badge--metal"
                },
                3: {
                  title: "MEDIUM BRAND",
                  class: "m-badge--primary"
                },
                4: {
                  title: "BIG BRAND",
                  class: "m-badge--success"
                },
                5: {
                  title: "INHOUSE-BRAND",
                  class: "m-badge--success"
                }

              };

              return void 0 === i[ a ] ? a : i[ a ].title;


            }
          },
          {
            targets: 4,
            render: function ( a, t, e, n )
            {
              var i = {
                1: {
                  title: "500-1000 UNIT",
                  class: "m-badge--brand"
                },
                2: {
                  title: "1000-2000 UNIT",
                  class: "m-badge--metal"
                },
                3: {
                  title: "2000-5000 UNIT",
                  class: "m-badge--primary"
                },
                4: {
                  title: "More than 5000",
                  class: "m-badge--success"
                },


              };

              return void 0 === i[ a ] ? a : i[ a ].title;


            }
          },
          {
            targets: 8,
            render: function ( a, t, e, n )
            {


              return e.order_status;

            }
          },
          {
            targets: 9,
            render: function ( a, t, e, n )
            {
              switch ( e.sample_catType )
              {
                case 1:
                  textCat = "COSMETICS";
                  break;
                case 2:
                  textCat = "OILS";
                  break;
                case 3:
                  textCat = "GEN CHANGES";
                  break;
                case 4:
                  textCat = "BENCHMARK";
                  break;
                case 5:
                  textCat = "MODIFICATIONS";
                  break;
                default:
                  textCat = "";
              }
              if ( e.admin_urgent_status == 1 )
              {
                textCat += `<br><strong style="color:red">URGENT</strong>`;
              }
              if ( e.sample_assignedTo == "" )
              {
                return textCat;
              } else
              {
                return textCat + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
              }


            }
          },


          {
            targets: 7,
            render: function ( a, t, e, n )
            {
              var pid = 6;
              var stargeName = "";
              switch ( e.sample_stage_id )
              {
                case 1:
                  stargeName = "NEW";
                  break;
                case 2:
                  stargeName = "APPROVED";
                  break;
                case 3:
                  stargeName = "FORMULATION";
                  break;
                case 4:
                  stargeName = "PACKING";
                  break;
                case 5:
                  stargeName = "DISPATCH";
                  break;


              }


              return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                                
                  ${ stargeName }
               
              </a>`;

              var i = {
                1: {
                  title: "NEW",
                  class: "m-badge--brand"
                },
                2: {
                  title: "SENT",
                  class: "m-badge--metal"
                },
                3: {
                  title: "RECIEVED",
                  class: "m-badge--primary"
                },
                4: {
                  title: "FEEDBACK",
                  class: "m-badge--success"
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

//m_table_SampletListFormulationSalesList
var DatatablesSearchOptionsAdvancedSearchSampleDataListV2FormulationSalesList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();
      var priority = $( '#priority' ).val();


      var URL_SAM = BASE_URL + '/getSamplesListFomulationSales';

      a = $( "#m_table_SampletListFormulationSalesList" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: URL_SAM,
          type: "GET",
          data: {
            columnsDef: [ "admin_urgent_status", "item_name", "brand_type", "order_size", "isEncrypt", "is_rejected", "RecordID", "formatation_status", "sample_assignedTo", "sample_stage_id", "edit_right", "sample_catType", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action,

          }
        },
        columns: [
          {
            data: "RecordID"
          },

          {
            data: "sample_code"
          },
          {
            data: "item_name"
          },
          {
            data: "company"
          },
          {
            data: "brand_type"
          },
          {
            data: "order_size"
          },
          {
            data: "created_on"
          },
          {
            data: "created_by"
          },

          {
            data: "formatation_status"
          },

          {
            data: "sample_catType"
          },


          {
            data: "Actions"
          }
        ],

        columnDefs: [
          {
            targets: [ 0, 7 ],
            visible: !1
          },
          {
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {
              sample_URL_LEAD = BASE_URL + '/stage_sales-leadv2Modify/' + e.RecordID;
              // sample_URL_LEAD = '00';


              var html = `<a href="${ sample_URL_LEAD }">Modify Request</a>`;




              return html;
            }
          },
          {
            targets: 4,
            render: function ( a, t, e, n )
            {
              var i = {
                1: {
                  title: "NEW BRAND",
                  class: "m-badge--brand"
                },
                2: {
                  title: "SMALL BRAND",
                  class: "m-badge--metal"
                },
                3: {
                  title: "MEDIUM BRAND",
                  class: "m-badge--primary"
                },
                4: {
                  title: "BIG BRAND",
                  class: "m-badge--success"
                },
                5: {
                  title: "INHOUSE-BRAND",
                  class: "m-badge--success"
                }

              };

              return void 0 === i[ a ] ? a : i[ a ].title;


            }
          },
          {
            targets: 5,
            render: function ( a, t, e, n )
            {
              var i = {
                1: {
                  title: "500-1000 UNIT",
                  class: "m-badge--brand"
                },
                2: {
                  title: "1000-2000 UNIT",
                  class: "m-badge--metal"
                },
                3: {
                  title: "2000-5000 UNIT",
                  class: "m-badge--primary"
                },
                4: {
                  title: "More than 5000",
                  class: "m-badge--success"
                },


              };

              return void 0 === i[ a ] ? a : i[ a ].title;


            }
          },
          {
            targets: 9,
            render: function ( a, t, e, n )
            {


              return e.sample_catType;

            }
          },
          {
            targets: 10,
            render: function ( a, t, e, n )
            {
              switch ( e.sample_catType )
              {
                case 1:
                  textCat = "COSMETICS";
                  break;
                case 2:
                  textCat = "OILS";
                  break;
                case 3:
                  textCat = "GEN CHANGES";
                  break;
                case 4:
                  textCat = "BENCHMARK";
                  break;
                case 5:
                  textCat = "MODIFICATIONS";
                  break;
                default:
                  textCat = "";
              }
              if ( e.admin_urgent_status == 1 )
              {
                textCat += `<br><strong style="color:red">URGENT</strong>`;
              }
              if ( e.sample_assignedTo == "" )
              {
                return textCat;
              } else
              {
                return textCat + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
              }


            }
          },


          {
            targets: 8,
            render: function ( a, t, e, n )
            {
              var pid = 6;
              var stargeName = "";
              switch ( e.formatation_status )
              {
                case 1:
                  stargeName = "FORMULATED";
                  break;
                case 0:
                  stargeName = "NA";
                  break;



              }


              return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING_Fv2A(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                                
                  ${ stargeName }
               
              </a>`;

              var i = {
                1: {
                  title: "NEW",
                  class: "m-badge--brand"
                },
                2: {
                  title: "SENT",
                  class: "m-badge--metal"
                },
                3: {
                  title: "RECIEVED",
                  class: "m-badge--primary"
                },
                4: {
                  title: "FEEDBACK",
                  class: "m-badge--success"
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

//m_table_SampletListFormulationSalesList


var DatatablesSearchOptionsAdvancedSearchSampleDataListV2Formulation = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var sample_action = $( '#txtSampleAction' ).val();
      var priority = $( '#priority' ).val();


      var URL_SAM = BASE_URL + '/getSamplesListFomulation';

      a = $( "#m_table_SampletListFormulation" ).DataTable( {
        // responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: URL_SAM,
          type: "GET",
          data: {
            columnsDef: [ "admin_urgent_status", "item_name", "brand_type", "order_size", "isEncrypt", "is_rejected", "RecordID", "formatation_status", "sample_assignedTo", "sample_stage_id", "edit_right", "sample_catType", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", 'order_status', "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'sample_action': sample_action,

          }
        },
        columns: [
          {
            data: "RecordID"
          },

          {
            data: "sample_code"
          },
          {
            data: "item_name"
          },
          {
            data: "company"
          },
          {
            data: "brand_type"
          },
          {
            data: "order_size"
          },
          {
            data: "created_on"
          },
          {
            data: "created_by"
          },

          {
            data: "sample_stage_id"
          },

          {
            data: "sample_catType"
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

              var html = '';




              return html;
            }
          },
          {
            targets: 4,
            render: function ( a, t, e, n )
            {
              var i = {
                1: {
                  title: "NEW BRAND",
                  class: "m-badge--brand"
                },
                2: {
                  title: "SMALL BRAND",
                  class: "m-badge--metal"
                },
                3: {
                  title: "MEDIUM BRAND",
                  class: "m-badge--primary"
                },
                4: {
                  title: "BIG BRAND",
                  class: "m-badge--success"
                },
                5: {
                  title: "INHOUSE-BRAND",
                  class: "m-badge--success"
                }

              };

              return void 0 === i[ a ] ? a : i[ a ].title;


            }
          },
          {
            targets: 5,
            render: function ( a, t, e, n )
            {
              var i = {
                1: {
                  title: "500-1000 UNIT",
                  class: "m-badge--brand"
                },
                2: {
                  title: "1000-2000 UNIT",
                  class: "m-badge--metal"
                },
                3: {
                  title: "2000-5000 UNIT",
                  class: "m-badge--primary"
                },
                4: {
                  title: "More than 5000",
                  class: "m-badge--success"
                },


              };

              return void 0 === i[ a ] ? a : i[ a ].title;


            }
          },
          {
            targets: 9,
            render: function ( a, t, e, n )
            {


              return e.sample_catType;

            }
          },
          {
            targets: 10,
            render: function ( a, t, e, n )
            {
              switch ( e.sample_catType )
              {
                case 1:
                  textCat = "COSMETICS";
                  break;
                case 2:
                  textCat = "OILS";
                  break;
                case 3:
                  textCat = "GEN CHANGES";
                  break;
                case 4:
                  textCat = "BENCHMARK";
                  break;
                case 5:
                  textCat = "MODIFICATIONS";
                  break;
                default:
                  textCat = "";
              }
              if ( e.admin_urgent_status == 1 )
              {
                textCat += `<br><strong style="color:red">URGENT</strong>`;
              }
              if ( e.sample_assignedTo == "" )
              {
                return textCat;
              } else
              {
                return textCat + "<br><b>Assign To:</b><br>" + e.sample_assignedTo;
              }


            }
          },


          {
            targets: 8,
            render: function ( a, t, e, n )
            {
              var pid = 6;
              var stargeName = "";
              switch ( e.sample_stage_id )
              {
                case 1:
                  stargeName = "NEW";
                  break;
                case 2:
                  stargeName = "APPROVED";
                  break;
                case 3:
                  stargeName = "FORMULATION";
                  break;
                case 4:
                  stargeName = "PACKING";
                  break;
                case 5:
                  stargeName = "DISPATCH";
                  break;


              }


              return `<a href="javascript::void(0)" onclick="GeneralViewStageSAMPLING_Fv2(${ pid },${ e.RecordID })"  class="btn btn-outline-red btn-sm 	m-btn m-btn--icon m-btn--outline-2x">
                                
                  ${ stargeName }
               
              </a>`;

              var i = {
                1: {
                  title: "NEW",
                  class: "m-badge--brand"
                },
                2: {
                  title: "SENT",
                  class: "m-badge--metal"
                },
                3: {
                  title: "RECIEVED",
                  class: "m-badge--primary"
                },
                4: {
                  title: "FEEDBACK",
                  class: "m-badge--success"
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
//datagrid Client list
var SampleDataListNEW = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_SampletListNew" ).DataTable( {
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
          url: BASE_URL + '/getSamplesListNew',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "sample_code", "company", "phone", "name", "created_on", "created_by", "location", "Status", "sent_access", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sample_code"
          },
          {
            data: "company"
          },
          {
            data: "phone"
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
            console.log();
            edit_URL = BASE_URL + '/sample/' + e.RecordID + '/edit';
            print_URL = BASE_URL + '/sample/print/' + e.RecordID;

            view_URL = BASE_URL + '/sample/' + e.RecordID + '';

            var html = `<a href="${ view_URL }" title="INFO" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="la la-info"></i>
                          </a>
                          <a href="${ edit_URL }" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                                <i class="la la-edit"></i>
                              </a> `;
            if ( e.sent_access )
            {
              html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="sent_sample(${ e.RecordID })"
                                   title="VIEW SAMPLE" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                                              <i class="flaticon-paper-plane-1"></i>
                                                              </a>`;
            }


            return html;
          }
        },
        {
          targets: 8,
          render: function ( a, t, e, n )
          {
            var i = {
              1: {
                title: "NEW",
                class: "m-badge--brand"
              },
              2: {
                title: "SENT",
                class: " m-badge--metal"
              },
              3: {
                title: "RECIEVED",
                class: " m-badge--primary"
              },
              4: {
                title: "FEEDBACK",
                class: " m-badge--success"
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

//m_table_QCFORMPurchaseListBOV1_LABEL_BOX_v1
var QCFROM_PURCHASE_LIST_BOV1_BOX_LABEL_V1 = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var purchaseFlag = $( '#txtPurchaseFlag' ).val();

      var buttonCommon = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node )
            {
              // Strip $ from salary column to make it numeric
              //console.log(data);
              if ( column === 9 || column === 1 || column === 8 || column === 10 )
              {
                //return  row;

                return '';



              } else
              {



                if ( column === 8 )
                {
                  var myStr = data;

                  var subStr = myStr.match( '<span>(.*)</span>' );

                  return subStr[ 1 ];


                }

                // 

                return data;
              }

            }
          }
        }
      };

      var a;
      a = $( "#m_table_QCFORMPurchaseListBOV1_LABEL_BOX_v1" ).DataTable( {
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

          url: BASE_URL + '/getPurchaseListQCFROM_V1_LABEL_BOX_v1',
          type: "GET",
          data: {
            columnsDef: [ "RecordID", 'bom_stage', "pricePartStatus", "update_status", "no_avil", "bom_Type", "PMCODE", "img_url", "pack_img", "form_id", "order_statge", "order_item_name", "order_index", "category", "qty", "status", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            '_days_count': $( '#txtNumberofdays' ).val(),
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
            data: "bom_stage"
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
          targets: 2,
          title: "Order ID",
          orderable: !1,
          render: function ( a, t, e, n )
          {

            return `${ e.order_id }`;


          }
        },
        {
          targets: 8,
          title: "Order Stage",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            // console.log(e);


            return e.order_statge;


          }
        },
        {
          targets: 7,
          title: "BOM Stage",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            var process_id = 2;

            var stStr = "";
            switch ( e.bom_stage )
            {
              case 1:
                stStr = "Not Started"
                break;
              case 2:
                stStr = "Design Awaited"
                break;
              case 3:
                stStr = "Sample Awaited"
                break;
              case 4:
                stStr = "Waiting for Quotation"
                break;
              case 5:
                stStr = "Ordered"
                break;
              case 6:
                stStr = "Received in Stock"
                break;
              case 7:
                stStr = "Received From Client"
                break;
              case 8:
                stStr = "Removed"
                break;


            }
            return `<a style="text-decoration:none" href="javascript::void(0)" onclick="showGeneralViewPurchase(${ process_id },${ e.RecordID },${ e.form_id })"  class="">
              <span>${ stStr }</span>
              </a>`;


          }
        },
        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            print_URL = BASE_URL + '/print/qcform/' + e.form_id;
            var html = "";

            html += `<a href="javascript::void(0)" onclick="viewOrderDataIMGPurchase(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>
                  <a href="${ print_URL }" target="_blank" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-print"></i>
          </a>
           <a href="javascript::void(0)" onclick="deleteFromPurchaseList(${ e.RecordID })" style="margin-bottom:3px" title="Delete from Purchase list" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
          <i class="la la-trash"></i>
          </a>
          `;

            if ( e.pricePartStatus == 1 )
            {
              html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-rupee-sign"></i>
                    </a> `;
            }

            return html;
            /* <a href="javascript::void(0)" onclick="deleteFromPurchaseList(${e.RecordID})" style="margin-bottom:3px" title="Delete from Purchase list" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="la la-trash"></i>
              </a>
              */


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
      } ),
        $( '#m_table_QCFORMPurchaseList' ).on( 'click', 'tbody td:not(:first-child)', function ( e )
        {
          editor.inline( this );
        } );
    }
  }
}();

//m_table_QCFORMPurchaseListBOV1_LABEL_BOX_v1


// QCFROM_PURCHASE_LIST_BOV1_BOX_LABEL
var QCFROM_PURCHASE_LIST_BOV1_BOX_LABEL = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var purchaseFlag = $( '#txtPurchaseFlag' ).val();

      var buttonCommon = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node )
            {
              // Strip $ from salary column to make it numeric
              //console.log(data);
              if ( column === 9 || column === 1 || column === 8 || column === 10 )
              {
                //return  row;

                return '';



              } else
              {



                if ( column === 8 )
                {
                  var myStr = data;

                  var subStr = myStr.match( '<span>(.*)</span>' );

                  return subStr[ 1 ];


                }

                // 

                return data;
              }

            }
          }
        }
      };

      var a;
      a = $( "#m_table_QCFORMPurchaseListBOV1_LABEL_BOX" ).DataTable( {
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

          url: BASE_URL + '/getPurchaseListQCFROM_V1_LABEL_BOX',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "update_status", "no_avil", "bom_Type", "PMCODE", "img_url", "pack_img", "form_id", "order_statge", "order_item_name", "order_index", "category", "qty", "status", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            '_days_count': $( '#txtNumberofdays' ).val(),
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
          targets: 8,
          title: "Order Stage",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            // console.log(e);


            return e.order_statge;


          }
        },
        {
          targets: 7,
          title: "BOM Stage",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            var process_id = 2;
            if ( e.bom_Type == 0 )
            {
              return `<a style="text-decoration:none" href="javascript::void(0)" onclick="showGeneralViewPurchase(${ process_id },${ e.RecordID },${ e.form_id })"  class="">
                <span>${ e.status } 
                
                <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Client</span>
                </span>
              </a>`;
            } else
            {
              if ( e.update_status == 1 )
              {

                return `<a style="text-decoration:none" href="javascript::void(0)" onclick="showGeneralViewPurchase(${ process_id },${ e.RecordID },${ e.form_id })"  class="">
                  <span>${ e.status }
                    <span class="m-badge m-badge--info m-badge--wide m-badge--rounded">Edited</span>
                  </span>
                  </a>`;

              } else
              {
                return `<a style="text-decoration:none" href="javascript::void(0)" onclick="showGeneralViewPurchase(${ process_id },${ e.RecordID },${ e.form_id })"  class="">
                  <span>${ e.status }</span>
                  </a>`;
              }

            }






          }
        },



        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            print_URL = BASE_URL + '/print/qcform/' + e.form_id;


            return `<a href="javascript::void(0)" onclick="viewOrderDataIMGPurchase(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>
                  <a href="${ print_URL }" target="_blank" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-print"></i>
          </a> 
                 
                  `;
            /* <a href="javascript::void(0)" onclick="deleteFromPurchaseList(${e.RecordID})" style="margin-bottom:3px" title="Delete from Purchase list" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="la la-trash"></i>
              </a>
              */


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
      } ),
        $( '#m_table_QCFORMPurchaseList' ).on( 'click', 'tbody td:not(:first-child)', function ( e )
        {
          editor.inline( this );
        } );
    }
  }
}();

// QCFROM_PURCHASE_LIST_BOV1_BOX_LABEL


function deleteFromPurchaseList( rowid )
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
        url: BASE_URL + "/deleteFromPurchaseListwithID",
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
                //location.reload();
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


var QCFROM_PURCHASE_LIST_BOV1 = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var purchaseFlag = $( '#txtPurchaseFlag' ).val();

      var buttonCommon = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node )
            {
              // Strip $ from salary column to make it numeric
              //console.log(data);
              if ( column === 9 || column === 1 || column === 8 || column === 10 )
              {
                //return  row;

                return '';



              } else
              {



                if ( column === 8 )
                {
                  var myStr = data;

                  var subStr = myStr.match( '<span>(.*)</span>' );

                  return subStr[ 1 ];


                }

                // 

                return data;
              }

            }
          }
        }
      };

      var a;
      a = $( "#m_table_QCFORMPurchaseListBOV1" ).DataTable( {
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

          url: BASE_URL + '/getPurchaseListQCFROM_V1',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "update_status", "no_avil", "bom_Type", "PMCODE", "img_url", "pack_img", "form_id", "order_statge", "order_item_name", "order_index", "category", "qty", "status", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            '_days_count': $( '#txtNumberofdays' ).val(),
            'purchaseFlag': purchaseFlag
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "img_url"
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
          targets: 3,
          title: "Order ID",
          orderable: !1,
          render: function ( a, t, e, n )
          {

            return `${ e.order_id }`;


          }
        },
        {
          targets: 9,
          title: "Order Stage",
          orderable: !1,
          render: function ( a, t, e, n )
          {

            return e.order_statge;


          }
        },
        {
          targets: 8,
          title: "BOM Stage",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            var process_id = 2;
            if ( e.no_avil == 1 )
            {
              if ( e.bom_Type == 0 )
              {
                return `<a style="text-decoration:none" href="javascript::void(0)" onclick="showGeneralViewPurchase(${ process_id },${ e.RecordID },${ e.form_id })"  class="">
                  <span>${ e.status } 
                  
                  <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Client</span>
                  </span>
                </a>`;
              } else
              {
                if ( e.update_status == 1 )
                {

                  return `<a style="text-decoration:none" href="javascript::void(0)" onclick="showGeneralViewPurchase(${ process_id },${ e.RecordID },${ e.form_id })"  class="">
                    <span>${ e.status }
                      <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Edited</span>
                    </span>
                    </a>`;

                } else
                {
                  return `<a style="text-decoration:none" href="javascript::void(0)" onclick="showGeneralViewPurchase(${ process_id },${ e.RecordID },${ e.form_id })"  class="">
                    <span>${ e.status }</span>
                    </a>`;
                }

              }

            } else
            {
              return `<a style="text-decoration:none" href="javascript::void(0)" onclick="showGeneralViewPurchase(${ process_id },${ e.RecordID },${ e.form_id })"  class="">
                <span>${ e.status }
                <span class="m-badge m-badge--danger m-badge--wide m-badge--rounded">Removed</span>

                </span>
              </a>`;
            }






          }
        },
        {
          targets: 1,
          render: function ( a, t, e, n )
          {
            return `<div class="m-widget3__item">
                <div class="m-widget3__header">
                  <div class="m-widget3__user-img">
                    <img class="m-widget3__img" width="60" src="${ e.img_url }" alt="">
                  </div>
                  <div class="m-widget3__info">
                    <span class="m-widget3__username">
                      ${ e.PMCODE }
                    </span><br>
                   
                  </div>
                  
                </div>
                
              </div>`;

          }
        },


        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            //console.log(e);
            print_URL = BASE_URL + '/print/qcform/' + e.form_id;

            return `<a href="javascript::void(0)" onclick="viewOrderDataIMGPurchase(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  <a href="${ print_URL }" target="_black" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-print"></i>
          </a> 
                  `;
            /* <a href="javascript::void(0)" onclick="deleteFromPurchaseList(${e.RecordID})" style="margin-bottom:3px" title="Delete from Purchase list" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-trash"></i>
          </a>
          */


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
      } ),
        $( '#m_table_QCFORMPurchaseList' ).on( 'click', 'tbody td:not(:first-child)', function ( e )
        {
          editor.inline( this );
        } );
    }
  }
}();

var QCFROM_PURCHASE_LIST_BOV1_AJ = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var purchaseFlag = $( '#txtPurchaseFlag' ).val();

      var buttonCommon = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node )
            {
              // Strip $ from salary column to make it numeric
              //console.log(data);
              if ( column === 9 || column === 1 )
              {
                //return  row;

                return '';



              } else
              {



                if ( column === 8 )
                {
                  var myStr = data;

                  var subStr = myStr.match( 'wide">(.*)</' );

                  return subStr[ 1 ];

                }

                // 

                return data;
              }

            }
          }
        }
      };

      var a;
      a = $( "#m_table_QCFORMPurchaseListBOV1_AJ" ).DataTable( {
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

          url: BASE_URL + '/getPurchaseListQCFROM_V1_MODFIED',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "PMCODE", "img_url", "pack_img", "form_id", "order_statge", "order_item_name", "order_index", "category", "qty", "status", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            '_days_count': $( '#txtNumberofdays' ).val(),
            'purchaseFlag': purchaseFlag
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "img_url"
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
          targets: 3,
          title: "Order ID",
          orderable: !1,
          render: function ( a, t, e, n )
          {

            return `${ e.order_id }`;


          }
        },
        {
          targets: 9,
          title: "Order Stage",
          orderable: !1,
          render: function ( a, t, e, n )
          {

            return e.order_statge;


          }
        },
        {
          targets: 8,
          title: "BOM Stage",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            var process_id = 2;


            return `<a style="text-decoration:none" href="javascript::void(0)" onclick="showGeneralViewPurchase(${ process_id },${ e.RecordID },${ e.form_id })"  class="">
              <span>
                
                <span>${ e.status }</span>
              </span>
            </a>`;


          }
        },
        {
          targets: 1,
          render: function ( a, t, e, n )
          {
            return `<div class="m-widget3__item">
                <div class="m-widget3__header">
                  <div class="m-widget3__user-img">
                    <img class="m-widget3__img" width="60" src="${ e.img_url }" alt="">
                  </div>
                  <div class="m-widget3__info">
                    <span class="m-widget3__username">
                      ${ e.PMCODE }
                    </span><br>
                   
                  </div>
                  
                </div>
                
              </div>`;

          }
        },


        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            //console.log(e);
            return `<a href="javascript::void(0)" onclick="viewOrderDataIMGPurchase(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
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
      } ),
        $( '#m_table_QCFORMPurchaseList' ).on( 'click', 'tbody td:not(:first-child)', function ( e )
        {
          editor.inline( this );
        } );
    }
  }
}();



var QCFROM_PURCHASE_LIST = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
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

          url: BASE_URL + '/getPurchaseListQCFROM',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "pack_img", "form_id", "order_statge", "order_item_name", "order_index", "category", "qty", "status", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            '_days_count': $( '#txtNumberofdays' ).val(),
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
      } ),
        $( '#m_table_QCFORMPurchaseList' ).on( 'click', 'tbody td:not(:first-child)', function ( e )
        {
          editor.inline( this );
        } );
    }
  }
}();









var QCFROM_PRODUCTION_LIST = function ()
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
              //console.log(data);
              if ( column === 11 )
              {
                //return  row;

                return '';



              } else
              {
                if ( column === 12 )
                {
                  return '';
                }
                if ( column === 9 )
                {
                  var myStr = data;

                  var subStr = myStr.match( 'wide">(.*)</' );


                  return subStr[ 1 ];

                } else
                {
                  return data;
                }

              }

            }
          }
        }
      };

      a = $( "#m_table_QCFORMProductionList" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 100, 5000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
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
        ajax: {

          url: BASE_URL + '/getQCFromProduction',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "purchaseReciveInStock", "order_stageData", "order_index", "order_statge_curr", "order_id", "brand_name", "item_name", "fm_sampleno", "created_at", "item_size_unit", "item_qty_unit", "batch_size", "order_statge", "sales_person", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
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
            data: "fm_sampleno"
          },
          {
            data: "order_id"
          },
          {
            data: "brand_name"
          },
          {
            data: "created_at"
          },
          {
            data: "item_size_unit"
          },
          {
            data: "item_qty_unit"
          },
          {
            data: "batch_size"
          },
          {
            data: "order_statge_curr"
          },
          {
            data: "order_stageData"
          },
          {
            data: "purchaseReciveInStock"
          },
          {
            data: "Actions"
          }
        ],

        columnDefs: [ {
          targets: [ 0, 10 ],
          visible: !1
        }, {
          targets: 9,
          render: function ( a, t, e, n )
          {
            var i = {
              1: {
                title: "NOT STARTED",
                class: "m-badge--secondary"
              },
              2: {
                title: "RM PURCHASE",
                class: "m-badge--accent"
              },
              3: {
                title: "PLANNED",
                class: " m-badge--info"
              },
              4: {
                title: "IN PROGRESS",
                class: " m-badge--primary"
              },
              5: {
                title: "QUALITY CHECK",
                class: " m-badge--warning"
              },
              6: {
                title: "COMPLETED",
                class: " m-badge--success"
              },

            };
            return void 0 === i[ a ] ? a : '<span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span>"
          }
        },
        {
          targets: 11,
          render: function ( a, t, e, n )
          {
            var i = {
              1: {
                title: "PENDING",
                class: "m-badge--secondary"
              },
              2: {
                title: "RECIEVED",
                class: "m-badge--success"
              },


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
                           <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStageProduction(${ e.RecordID },1)"> ${ e.status == 1 ? '<i class="fa fa-hand-point-right faa-horizontal animated" style="color:#008080"></i>' : '' } NOT STARTED</a>
                           <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStageProduction(${ e.RecordID },2)"> ${ e.status == 2 ? '<i class="fa fa-hand-point-right faa-horizontal animated" style="color:#008080"></i>' : '' } RM PURCHASE</a>
                           <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStageProduction(${ e.RecordID },3)"> ${ e.status == 3 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' } PLANNED</a>
                           <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStageProduction(${ e.RecordID },4)"> ${ e.status == 4 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' } IN PROGRESS</a>
                           <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStageProduction(${ e.RecordID },5)"> ${ e.status == 5 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' } QUALITY CHECK</a>
                           <a class="dropdown-item" href="javascript::void(0)" onclick="QC_orderStageProduction(${ e.RecordID },6)"> ${ e.status == 6 ? '<i class="fa fa-hand-point-right" style="color:#008080"></i>' : '' } COMPLETED </a>
                           
                           </div>
                           </span>`;


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
      } ),
        $( '#m_table_QCFORMPurchaseList' ).on( 'click', 'tbody td:not(:first-child)', function ( e )
        {
          editor.inline( this );
        } );
    }
  }
}();






var QCFROMLISTStagePendingList = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_QCFORMListPendingStage" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [

          {
            extend: 'excelHtml5',
            exportOptions: {
              columns: ':visible'
            }
          },
          {
            extend: 'pdfHtml5',
            exportOptions: {
              columns: ':visible'
            }
          },
          'colvis'
        ],
        ajax: {

          url: BASE_URL + '/getQcOrderStagePendingList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "curr_order_statge", "edit_qc_from", "order_value", "role_data", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'txtMyMark': $( '#txtMyMark' ).val(),
            'txtStepCode': $( '#txtStepCode' ).val(),

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
            data: "Actions"
          }
        ],

        columnDefs: [ {
          targets: [ 0 ],
          visible: !1
        },
        {
          targets: 5,
          title: "Order Value",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            // console.log(e);
            if ( e.role_data == 'Admin' || e.role_data == 'SalesUser' )
            {
              return '<i class="fa fa-rupee-sign"></i> ' + e.order_value;
            } else
            {
              return 'NA';
            }

          }
        },
        {
          targets: -2,
          title: "Current Stages",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            return `<a href="javascript::void(0)" style="text-decoration:none" onclick="showmeMyStatge(${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;


          }
        },
        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {

            edit_URL = BASE_URL + '/qcform/' + e.form_id + '/edit';
            manageOrder_URL = BASE_URL + '/order-wizard/' + e.form_id;
            print_URL = BASE_URL + '/print/qcform/' + e.form_id;
            view_URL = BASE_URL + '/sample/' + e.RecordID + '';
            edit_URL = '#';
            if ( e.role_data == 'Staff' )
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
                     `;



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
                    <a href="${ manageOrder_URL }" title="Manage Order" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-interface-3"></i>
                    </a> 
                    <a href="javascript::void(0)" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a> 
                    <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    
                     `;
            }
            if ( e.role_data == 'SalesUser' )
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
    }
  }
}();




// view client order
var QCFROMLIST_CLIENTORDER = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
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
      var client_ID = $( '#txtClientID_OrderID' ).val();

      a = $( "#m_table_QCFORMList_VIEWCLIENT" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [

          $.extend( true, {}, buttonCommonORDER, {
            extend: 'excelHtml5'
          } ),
          $.extend( true, {}, buttonCommonORDER, {
            extend: 'pdfHtml5'
          } )

        ],
        ajax: {

          url: BASE_URL + '/qcformGetList_OrderLIst',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "order_type", "bulk_data", "bulkOrderValueData", "qc_from_bulk", "order_typeNew", "bulkCount", "curr_order_statge", "edit_qc_from", "order_value", "role_data", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'client_ID': client_ID
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
            console.log( e.bulk_data );
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
          targets: 5,
          title: "Order Value",
          orderable: !0,
          render: function ( a, t, e, n )
          {
            // console.log(e);
            if ( e.role_data == 'Admin' || e.role_data == 'SalesUser' )
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
            return `<a href="javascript::void(0)" style="text-decoration:none" onclick="showmeMyStatge(${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;


          }
        },
        {
          targets: -1,
          title: "Actions",
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
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-copy"></i>
                  </a> 
                    
                     `;
            }
            if ( e.role_data == 'SalesUser' )
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
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-copy"></i>
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
    }
  }
}();

// view client order


// V1Access order list
var QCFROMLIST_V1ORDERLISTAccess = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var buttonCommonORDER = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node )
            {
              // Strip $ from salary column to make it numeric
              //console.log(data);
              if ( UID != 1 )
              {
                return '';
              }
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




      a = $( "#m_table_QCFORMList_v1OrderListAcccess" ).DataTable( {
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
            data: "item_name"
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
            data: "Actions"
          }
        ],

        columnDefs: [ {
          targets: [ 0 ],
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
          targets: -3,
          title: "Current Stages",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            var process_id = 1;
            return `<a href="javascript::void(0)" style="text-decoration:none" onclick="GeneralViAewStage(${ process_id },${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;


          }
        },
        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {

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
              edit_URL = BASE_URL + '/qcform/bulk/' + e.form_id + '/edit';
            }
            copy_URL = BASE_URL + '/qcform/' + e.form_id + '/copy-order';

            //console.log(e.qc_from_bulk);
            if ( UID == 88 || UID == 1 || UID == 118 )
            {
              var html = `<a href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                    `;
              return html;
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
    }
  }
}();


// V1Access order list

//m_table_ActivityListUser
var QCFROMLIST_ActivityLISTUSER = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;




      a = $( "#m_table_ActivityListUser" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [


        ],
        ajax: {

          url: BASE_URL + '/getActivityUserListData',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "event_name", "event_id", "created_by", "created_photo", "created_at",
              "event_info",

              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "event_name"
          },
          {
            data: "event_id"
          },
          {
            data: "event_info"
          },

          {
            data: "created_by"
          },

          {
            data: "created_at"
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

              return ''

              return `<a href="javascript::void(0)" onclick="viewTicketInfo(${ e.RecordID })"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                       <span>
                         <i class="fa flaticon-eye"></i>
                         <span>View</span>
                       </span>
                     </a>  
                     `



            }
          },
          {
            targets: 0,
            width: 20,

          },


          {
            width: 200,
            targets: 4,
            render: function ( a, t, e, n )
            {

              var HTML = `<div class="m-list-pics m-list-pics--sm m--padding-left-20">`;


              HTML += `<a href="javascript::void()"    data-toggle="m-tooltip" class="tooltip-test" title="" data-original-title="Tooltip" ><img src="${ e.created_photo }" title="${ e.created_by }"></a> ${ e.created_by }`


              HTML += `</div>`
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

//m_table_ActivityListUser
//m_table_leadOncreditRequest
var QCFROMLIST_LeadCompter = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;




      a = $( "#m_table_leadOncreditRequest" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [


        ],
        ajax: {

          url: BASE_URL + '/getOnCreditRequest',
          type: "GET",
          data: {
            columnsDef: [ "RecordID",
              "brand",
              "company",
              "name",
              "phone",
              "created_by",
              "approved_on",
              "approved_by",
              "approvedmsg",
              "status",
              "file_link",
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
            data: "brand"
          },
          {
            data: "company"
          },

          {
            data: "name"
          },

          {
            data: "phone"
          },
          {
            data: "approvedmsg"
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
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {
              var HTML = "";

              if ( _UNIB_RIGHT == 'Admin' )
              {

                if ( e.status == 1 || e.status == 3 || e.status == 4 )
                {
                  return `<a href="javascript::void(0)" onclick="oncreditLeadActionView(${ e.RecordID })"  class="btn btn-primary m-btn btn-sm 	m-btn m-btn--icon">
                <span>
                  <i class="fa flaticon-eye"></i>
                  
                </span>
              </a>  
              `
                } else
                {
                  return '--'
                }

              } else
              {
                if ( e.status == 4 )
                {
                  HTML += `<a title="Delete Request" style="margin-top:2px" href="javascript::void(0)" onclick="DeleteEditReq(${ e.RecordID })"  class="btn btn-danger m-btn btn-sm 	m-btn m-btn--icon">
                      <span>
                        <i class="fa flaticon-delete"></i>
                        <span>Delete</span>
                      </span>
                    </a>  
                    `;

                } else
                {
                  return '';
                }

              }
              return HTML;




            }
          },
          {
            targets: 0,
            width: 20,

          },



          {
            targets: 6,
            render: function ( a, t, e, n )
            {
              var i = {
                1: {
                  title: "PENDING",
                  class: "m-badge--warning"
                },
                2: {
                  title: "APPROVED",
                  class: " m-badge--success"
                },
                3: {
                  title: "REJECTED",
                  class: " m-badge--danger"
                },
                4: {
                  title: "HOLD",
                  class: " m-badge--primary"
                },






              };
              return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusOnCreditRequest(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
            }
          },
          {
            width: 200,
            targets: 4,
            render: function ( a, t, e, n )
            {

              var HTML = `Requested On:<br>${ e.created_at }`;
              HTML += `<br>Requested By:<br>${ e.created_by }`;
              return HTML;

            }
          },
          {
            width: 200,
            targets: 5,
            render: function ( a, t, e, n )
            {
              if ( e.approved_on == null )
              {
                var HTML = `Waiting for Reponse`;
                return HTML;
              } else
              {
                var HTML = `Response On:<br>${ e.approved_on }`;
                HTML += `<br>Response By:<br>${ e.approved_by }`;
                HTML += `<br>Msg:<br><b>${ e.approvedmsg }</b>`;
                return HTML;
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
//m_table_leadOncreditRequest


//m_table_orderEditListUser
var QCFROMLIST_OrderEditLISTUSER = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;




      a = $( "#m_table_orderEditListUser" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [


        ],
        ajax: {

          url: BASE_URL + '/getOrderEditListData',
          type: "GET",
          data: {
            columnsDef: [ "RecordID", "order_id", "edit_type", "notes", "created_by", "approved_on",
              "approved_by",
              "approvedmsg",
              "created_at",
              "status",
              "file_link",
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
            data: "edit_type"
          },

          {
            data: "notes"
          },

          {
            data: "created_at"
          },
          {
            data: "approvedmsg"
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
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {
              var HTML = "";

              if ( _UNIB_RIGHT == 'Admin' || _UNIB_RIGHT == "SalesHead" || UID == 156 )
              {

                if ( e.status == 4 || e.status == 3 )
                {
                  return `<a href="javascript::void(0)" onclick="orderEditActionView(${ e.RecordID })"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                <span>
                  <i class="fa flaticon-eye"></i>
                  
                </span>
              </a>  
              `
                } else
                {
                  return ''
                }

              } else
              {
                if ( e.status == 4 )
                {
                  HTML += `<a title="Delete Request" style="margin-top:2px" href="javascript::void(0)" onclick="DeleteEditReq(${ e.RecordID })"  class="btn btn-danger m-btn btn-sm 	m-btn m-btn--icon">
                      <span>
                        <i class="fa flaticon-delete"></i>
                        <span>Delete</span>
                      </span>
                    </a>  
                    `;

                } else
                {
                  return '';
                }

              }
              return HTML;




            }
          },
          {
            targets: 0,
            width: 20,

          },
          {
            targets: 2,
            render: function ( a, t, e, n )
            {
              var i = {
                1: {
                  title: "PRICE CHANGES",
                  class: "m-badge--primary"
                },
                2: {
                  title: "QTY CHANGES",
                  class: " m-badge--warning"
                },
                3: {
                  title: "ITEM CHANGES",
                  class: " m-badge--success"
                },
                4: {
                  title: "SAMPLES ID CHANGES",
                  class: " m-badge--success"
                },
                5: {
                  title: "OTHERS",
                  class: " m-badge--success"
                },


              };
              return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="TicketResponse(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
            }
          },


          {
            targets: 6,
            render: function ( a, t, e, n )
            {
              var i = {
                1: {
                  title: "APPROVED",
                  class: " m-badge--success"
                },
                2: {
                  title: "REJECTED",
                  class: " m-badge--danger"
                },
                3: {
                  title: "HOLD",
                  class: " m-badge--warning"
                },
                4: {
                  title: "PENDING",
                  class: "m-badge--brand"
                },





              };
              return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusSaleJInvoice(' + e.form_id + ',' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
            }
          },
          {
            width: 200,
            targets: 4,
            render: function ( a, t, e, n )
            {

              var HTML = `Requested On:<br>${ e.created_at }`;
              HTML += `<br>Requested By:<br>${ e.created_by }`;
              return HTML;

            }
          },
          {
            width: 200,
            targets: 5,
            render: function ( a, t, e, n )
            {

              if ( e.status != 4 )
              {
                var HTML = `Response On:<br>${ e.approved_on }`;
                HTML += `<br>Response By:<br>${ e.approved_by }`;
                HTML += `<br>Msg:<br><b>${ e.approvedmsg }</b>`;
                return HTML;
              } else
              {
                var HTML = `Waiting for Reponse`;

                return HTML;
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

//m_table_orderEditListUser


//m_table_TicketV2List
var QCFROMLIST_TICKETV2 = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;




      a = $( "#m_table_TicketV2List" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [


        ],
        ajax: {

          url: BASE_URL + '/getTicketListDatav2',
          type: "POST",
          data: {
            columnsDef: [
              "RecordID",
              "status",
              "ticket_type_name",
              "created_by_name",
              "assinged_to_name",
              "priority_name",
              "priority_id",
              "created_at",
              "since_ago",
              "docURl",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "status"
          },
          {
            data: "ticket_type_name"
          },

          {
            data: "created_by_name"
          },

          {
            data: "assinged_to_name"
          },
          {
            data: "priority_id"
          },

          {
            data: "created_at"
          },
          {
            data: "docURl"
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



              return `<a href="javascript::void(0)" onclick="viewTicketInfoV2(${ e.RecordID })"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                       <span>
                         <i class="fa flaticon-eye"></i>
                         <span>View</span>
                       </span>
                     </a>  
                     `



            }
          },
          {
            targets: 0,
            width: 20,

          },
          {
            targets: 1,
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
              return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="TicketResponseSS(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
            }
          },


          {
            targets: 5,
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
            targets: 6,
            render: function ( a, t, e, n )
            {
              return e.created_at + `<br>
            <span class="m-badge  m-badge--secondary m-badge--wide"> ${ e.since_ago }</span>

           `;
            }
          },
          {
            targets: 7,
            render: function ( a, t, e, n )
            {
              return `<a target="_blank" href="${ e.docURl }">Attachement</a>`;
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
//m_table_TicketV2List

// m_table_TicketListUser
var QCFROMLIST_TICKETLISTUSER = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;




      a = $( "#m_table_TicketListUser" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [


        ],
        ajax: {

          url: BASE_URL + '/getTicketListData',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "ticket_id", "ticket_type", "ticket_subject", "ticket_status", "created_by",
              "priority_type",
              "created_at",
              "assignTo",
              "since_ago",
              "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "ticket_status"
          },
          {
            data: "ticket_type"
          },

          {
            data: "created_by"
          },

          {
            data: "created_at"
          },
          {
            data: "priority_type"
          },

          {
            data: "created_at"
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



              return `<a href="javascript::void(0)" onclick="viewTicketInfo(${ e.RecordID })"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                       <span>
                         <i class="fa flaticon-eye"></i>
                         <span>View</span>
                       </span>
                     </a>  
                     `
              //  <a target="_blank" href="${e.qc_URL}" class="btn btn-info m-btn btn-sm 	m-btn m-btn--icon">
              //    <span>
              //      <i class="fa flaticon-list"></i>
              //      <span>View QC</span>
              //    </span>
              //  </a>  


            }
          },
          {
            targets: 0,
            width: 20,

          },
          {
            targets: 1,
            render: function ( a, t, e, n )
            {
              var i = {
                0: {
                  title: "PENDING",
                  class: "m-badge--primary"
                },
                1: {
                  title: "OPEN",
                  class: " m-badge--warning"
                },
                2: {
                  title: "CLOSED",
                  class: " m-badge--success"
                },
                3: {
                  title: "RE_OPEN",
                  class: " m-badge--success"
                },


              };
              return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="TicketResponse(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
            }
          },

          {
            width: 200,
            targets: 4,
            render: function ( a, t, e, n )
            {

              var HTML = `<div class="m-list-pics m-list-pics--sm m--padding-left-20">`;

              data = $.parseJSON( e.assignTo );
              $.each( data, function ( i, v )
              {

                HTML += `<a href="javascript::void()"    data-toggle="m-tooltip" class="tooltip-test" title="" data-original-title="Tooltip" ><img src="${ v.profile_pic }" title="${ v.name }"></a>`
              } );
              HTML += `</div>`
              return HTML;

            }
          },
          {
            targets: 5,
            render: function ( a, t, e, n )
            {
              var i = {
                0: {
                  title: "NORMAL",
                  class: "m-badge--seconday"
                },
                1: {
                  title: "HIGH",
                  class: " m-badge--danger"
                },
                2: {
                  title: "MODERATE",
                  class: " m-badge--warning"
                },


              };
              return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusSaleJInvoice(' + e.form_id + ',' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
            }
          },
          {
            targets: 6,
            render: function ( a, t, e, n )
            {
              return e.created_at + `<br>
            <span class="m-badge  m-badge--secondary m-badge--wide"> ${ e.since_ago }</span>

           `;
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

//moveMembertoManagerTeam_Mode
function moveMembertoManagerTeam_Mode( rowid )
{
  $( '#m_modal_5_MoveTeamMember' ).modal( 'show' );
}

$( '#btnSavewithMoveL3inL2' ).click( function ()
{

  var selectedUserid1 = $( '.mangerIDataSelect1' ).children( "option:selected" ).val();
  var selectedUseri2 = $( '.mangerIDataSelect2' ).children( "option:selected" ).val();


  // ajax save data 
  var formData = {

    'selectedUserid1': selectedUserid1,
    'selectedUseri2': selectedUseri2,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/moveTeamMember2member',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      //console.log( res );
      toasterOptions();
      toastr.success( 'Submitted Successfully ', 'TeamMember' );
      setTimeout( function ()
      {
        // window.location.href = BASE_URL+'/orders'
        location.reload( 1 );


      }, 500 );


    }
  } );


  // ajax save data 
} );


//ajax

//moveMembertoManagerTeam_Mode

// add new team member modal
function addNewTeamMember_Mode( rowid )
{

  // ajax
  var formData = {
    'userid': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getUserDataByID',
    type: 'GET',
    data: formData,
    success: function ( res )
    {
      $( '.ajpicAva' ).html( "" );
      $( '.ajpicAva' ).append( `<img src="${ res.user_photo }" class="m--img-rounded m--marginless" width="40px" alt="${ res.user_name }">` );
      $( '.ajmName' ).html( res.user_name );
      $( '.ajphone' ).html( res.user_phone );
      $( '#txtUserID' ).val( rowid );
      $( '#m_modal_5_addnewTeamMember' ).modal( 'show' );

      $( '#btnSaveL3inL2' ).click( function ()
      {

        var selectedUserid = $( '.mangerIDataSelect' ).children( "option:selected" ).val();
        // ajax save data 
        var formData = {
          'userid': rowid,
          'selectedUserid': selectedUserid,
          '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
        };
        $.ajax( {
          url: BASE_URL + '/setTeamMember2member',
          type: 'POST',
          data: formData,
          success: function ( res )
          {
            console.log( res );
            toasterOptions();
            toastr.success( 'Submitted Successfully ', 'TeamMember' );
            setTimeout( function ()
            {
              //window.location.href = BASE_URL+'/orders'
              location.reload( 1 );


            }, 500 );


          }
        } );


        // ajax save data 
      } );

    },
    dataType: "json"
  } );
  //ajax
}
// add new team member modal
//startSampleProvess
function startSampleProvess( rowid )
{
  $( '#txtTicIDSID' ).val( rowid );
  $( '#m_modal_5TICKETRESPSamleid' ).modal( 'show' );
}
//btnSampleprocessResponse

$( '#btnSampleprocessResponse' ).click( function ()
{
  var TID = $( '#txtTicIDSID' ).val();
  var txtMess = $( '#txtSampleprocessRepMessage' ).val();
  var txtTicketSelectResp = $( '#txtSampleSelectResp' ).val();

  // ajax
  var formData = {
    'sid': TID,
    'txtMess': txtMess,
    'respType': txtTicketSelectResp,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setSampleProcessResponse',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status )
      {
        toasterOptions();
        toastr.success( 'Submitted Successfully ', 'Support' );
        setTimeout( function ()
        {
          //window.location.href = BASE_URL+'/orders'
          location.reload( 1 );


        }, 500 );

        return true;
      }
    },
    dataType: 'json'
  } );

  // ajax
} );

//btnSampleprocessResponse

//startSampleProvess

// TicketResponse
function TicketResponse( rowid )
{
  $( '#txtTicID' ).val( rowid );
  $( '#m_modal_5TICKETRESP' ).modal( 'show' );
}
$( '#btnTicketResponse' ).click( function ()
{
  var TID = $( '#txtTicID' ).val();
  var txtMess = $( '#txtTicketRepMessage' ).val();
  var txtTicketSelectResp = $( '#txtTicketSelectResp' ).val();

  // ajax
  var formData = {
    'TID': TID,
    'txtMess': txtMess,
    'txtTicketSelectResp': txtTicketSelectResp,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setTicketResponseSELF',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status )
      {
        toasterOptions();
        toastr.success( 'Submitted Successfully ', 'Support' );
        setTimeout( function ()
        {
          //window.location.href = BASE_URL+'/orders'
          location.reload( 1 );


        }, 500 );

        return true;
      }
    },
    dataType: 'json'
  } );

  // ajax
} );
// TicketResponse
// m_table_TicketListUser
// m_table_PAYMENT_REQUEST
// V1 order list
var QCFROMLIST_V1PAYMENTLIST_HIST = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;




      a = $( "#m_table_PAYMENT_REQUEST" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [


        ],
        ajax: {

          url: BASE_URL + '/getPaymentReqestList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID",
              "payment_date",
              "c_name", "c_phone", "c_company",
              "requested_on",
              "amount",
              "amount_word",
              "status",
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
            data: "c_phone"
          },
          {
            data: "requested_on"
          },
          {
            data: "amount"
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
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              var HTML = '';

              HTML += `<a title="View  Request" href="javascript::void(0)" onclick="viewPayReqData(${ e.RecordID })"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                       <span>
                         <i class="fa flaticon-eye"></i>
                         <span>View</span>
                       </span>
                     </a>  
                     `;
              if ( e.status == 1 || e.status == 3 )
              {

              } else
              {
                HTML += `<a title="Delete Request" style="margin-top:2px" href="javascript::void(0)" onclick="DeletePayReqData(${ e.RecordID })"  class="btn btn-danger m-btn btn-sm 	m-btn m-btn--icon">
                      <span>
                        <i class="fa flaticon-delete"></i>
                        <span>Delete</span>
                      </span>
                    </a>  
                    `;
              }
              return HTML;
              //  <a target="_blank" href="${e.qc_URL}" class="btn btn-info m-btn btn-sm 	m-btn m-btn--icon">
              //    <span>
              //      <i class="fa flaticon-list"></i>
              //      <span>View QC</span>
              //    </span>
              //  </a>  


            }
          },
          {
            targets: 7,
            render: function ( a, t, e, n )
            {
              var i = {
                0: {
                  title: "PENDING",
                  class: "m-badge--default"
                },
                1: {
                  title: "RECIEVED",
                  class: " m-badge--success"
                },
                2: {
                  title: "NOT RECIEVED",
                  class: " m-badge--danger"
                },
                3: {
                  title: "HOLD",
                  class: " m-badge--warning"
                },

              };
              return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Payment Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="NOWAYchangeStatusSaleJInvoice(' + e.form_id + ',' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
            }
          },
          {
            targets: 6,
            render: function ( a, t, e, n )
            {

              return `<span  title="${ e.amount_word }" class="m-badge m-badge--secondary m-badge--wide">${ e.amount }</span>`;
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




//DeleteEditReq
function DeleteEditReq( rowid )
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
        url: BASE_URL + "/deleteOrderEditRequest",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), s_id: rowid },
        success: function ( resp )
        {

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
            swal( "Deleted!", "Your Payment Requeste has been deleted.", "success" ).then( function ( eyz )
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

//DeleteEditReq


function DeletePayReqData( rowid )
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
        url: BASE_URL + "/deletePaymentRequest",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), s_id: rowid },
        success: function ( resp )
        {

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
            swal( "Deleted!", "Your Payment Requeste has been deleted.", "success" ).then( function ( eyz )
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


function viewPayReqData( id )
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

// m_table_PAYMENT_REQUEST

//m_table_oncreditLeadList
var QCFROMLIST_V1_ONCREDITLEAD = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;




      a = $( "#m_table_oncreditLeadList" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [


        ],
        ajax: {

          url: BASE_URL + '/getLeadOnCredittList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID",
              "sales_person", "company", "brand", "firstname", "phone", "created_at_lead", "have_order_count", "created_at", "status", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sales_person"
          },
          {
            data: "company"
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
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              var URLLINK = BASE_URL + '/view-all-lead-details/' + e.client_id
              var HTML = '';

              HTML += `<a href="javascript::void(0)" onclick="viewLeadonCreditData(${ e.RecordID })"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
              <span>
                <i class="fa flaticon-eye"></i>               
              </span>
              </a>`;


              return HTML;





            }
          },
          {
            targets: 2,
            render: function ( a, t, e, n )
            {
              return e.company + "<br>"
                + e.brand + "<br>"
                + e.firstname + "<br>"
                + e.phone + "<br><b>Order:</b>"
                + e.have_order_count;
            }
          },
          {
            targets: 4,
            render: function ( a, t, e, n )
            {
              var i = {
                1: {
                  title: "PENDING",
                  class: "m-badge--default"
                },
                2: {
                  title: "COMPLETED",
                  class: " m-badge--success"
                },
                3: {
                  title: "ON HOLD",
                  class: " m-badge--warning"
                },

              };
              return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusSaleJInvoice(' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
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

//m_table_oncreditLeadList

// m_table_salesInvoiceRequestHIST 


// V1 order list
var QCFROMLIST_V1SALEINOCIELIST_HIST = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;




      a = $( "#m_table_salesInvoiceRequestHIST" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [


        ],
        ajax: {

          url: BASE_URL + '/getSalesInvoiceReqestList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "feedcount", "client_id", "strFocFile", "form_id", "qc_URL", "sales_person", "order_id", "created_at", "status", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sales_person"
          },
          {
            data: "order_id"
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
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              var URLLINK = BASE_URL + '/view-all-lead-details/' + e.client_id
              var HTML = '';

              HTML += `<a href="javascript::void(0)" onclick="viewSalesInvoiceData(${ e.RecordID })"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
              <span>
                <i class="fa flaticon-eye"></i>
                <span>View</span>
              </span>
              </a>`;




              if ( e.strFocFile == 0 )
              {

              } else
              {
                HTML += ` <a style="margin-top:2px" href="${ URLLINK }"    title="GET Invoice" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="fa fa-file-pdf"></i>
              </a>`;
              }
              HTML += ` <a title ="Add Feedback" href="javascript::void(0)" onclick="viewSalesInvoiceDataFeedback(${ e.RecordID })"  class="btn btn-primary m-btn btn-sm 	m-btn m-btn--icon">
              <span>
              <span class="m-badge m-badge--light m-badge--bordered m-badge-bordered--info">${ e.feedcount }</span>
               
              </span>
              </a>`;

              if ( e.status == 0 )
              {
                HTML += ` <a href="javascript::void(0)" onclick="DeleteSalesInvoiceDataD(${ e.RecordID })"  class="btn btn-danger m-btn btn-sm 	m-btn m-btn--icon">
<span>
<i class="flaticon-delete"></i>
 
</span>
</a>`;
              }


              return HTML;



              //    return `<a href="javascript::void(0)" onclick="viewSalesInvoiceData(${e.RecordID})"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
              //    <span>
              //      <i class="fa flaticon-eye"></i>
              //      <span>View</span>
              //    </span>
              //  </a>  
              //  `
              //  <a target="_blank" href="${e.qc_URL}" class="btn btn-info m-btn btn-sm 	m-btn m-btn--icon">
              //    <span>
              //      <i class="fa flaticon-list"></i>
              //      <span>View QC</span>
              //    </span>
              //  </a>  


            }
          },
          {
            targets: 4,
            render: function ( a, t, e, n )
            {
              var i = {
                0: {
                  title: "PENDING",
                  class: "m-badge--default"
                },
                1: {
                  title: "COMPLETED",
                  class: " m-badge--success"
                },
                2: {
                  title: "ON HOLD",
                  class: " m-badge--warning"
                },

              };
              return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusSaleJInvoice(' + e.form_id + ',' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
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


// m_table_salesInvoiceRequestHIST


// m_table_salesInvoiceRequest
// V1 order list
var QCFROMLIST_V1SALEINOCIELIST = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;




      a = $( "#m_table_salesInvoiceRequest" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [


        ],
        ajax: {

          url: BASE_URL + '/getSalesInvoiceReqestList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "brand", "feedcount", "client_id", "strFocFile", "form_id", "qc_URL", "sales_person", "order_id", "created_at", "status", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [
          {
            data: "RecordID"
          },
          {
            data: "sales_person"
          },
          {
            data: "order_id"
          },
          {
            data: "brand"
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
            targets: -1,
            title: "Actions",
            orderable: !1,
            render: function ( a, t, e, n )
            {

              var HTML = '';
              var URLLINK = BASE_URL + '/view-all-lead-details/' + e.client_id
              if ( UID == 147 || UID == 175 || UID == 185 )
              {
                HTML += `<a href="javascript::void(0)" onclick="viewSalesInvoiceData(${ e.RecordID })"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                <span>
                  <i class="fa flaticon-eye"></i>
                  <span>View</span>
                </span>
              </a><br>`;

                HTML += `<a style="margin-top:1px" href="javascript::void(0)"   onclick="addPayOrderApprovalModelInvoiceByRequest(${ e.form_id })" title="Add Invoice" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="flaticon-file"></i>
              </a>`;

                return HTML;

              }

              HTML += `<a href="javascript::void(0)" onclick="viewSalesInvoiceData(${ e.RecordID })"  class="btn btn-warning m-btn btn-sm 	m-btn m-btn--icon">
                    <span>
                      <i class="fa flaticon-eye"></i>
                      <span>View</span>
                    </span>
                  </a><br>`;

              HTML += `<a style="margin-top:1px" href="javascript::void(0)"   onclick="addPayOrderApprovalModelInvoiceByRequest(${ e.form_id })" title="Add Invoice" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="flaticon-file"></i>
                  </a>`;

              if ( e.strFocFile == 0 )
              {

              } else
              {
                if ( e.client_id == 0 )
                {
                  HTML += ` <a style="margin-top:1px" href="javascript::void(0)"    title="No Invoice Added" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-file-pdf"></i>
                  </a>`;
                } else
                {
                  HTML += ` <a style="margin-top:1px" href="${ URLLINK }"    title="GET Invoice" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-file-pdf"></i>
                  </a>`;
                }

              }

              HTML += ` <a title ="Add Feedback" href="javascript::void(0)" onclick="viewSalesInvoiceDataFeedback(${ e.RecordID })"  class="btn btn-primary m-btn btn-sm 	m-btn m-btn--icon">
              <span>
              <span class="m-badge m-badge--light m-badge--bordered m-badge-bordered--info">${ e.feedcount }</span>
               
              </span>
              </a>`;


              if ( e.status == 0 )
              {
                HTML += ` <a href="javascript::void(0)" onclick="DeleteSalesInvoiceDataD(${ e.RecordID })"  class="btn btn-danger m-btn btn-sm 	m-btn m-btn--icon">
                    <span>
                    <i class="flaticon-delete"></i>
                     
                    </span>
                  </a>`;
              }
              if ( UID == 132 | UID == 1 )
              {
                HTML += ` <a title="Approval for SAP Invoice" href="javascript::void(0)" onclick="ApprovedForSAPINvoice(${ e.form_id },${ e.RecordID })"  class="btn btn-primary m-btn btn-sm 	m-btn m-btn--icon">
                <span>
                <i class="flaticon-plus"></i>
                 
                </span>
              </a>`;

              }


              return HTML;

              //  <a target="_blank" href="${e.qc_URL}" class="btn btn-info m-btn btn-sm 	m-btn m-btn--icon">
              //    <span>
              //      <i class="fa flaticon-list"></i>
              //      <span>View QC</span>
              //    </span>
              //  </a>  


            }
          },
          {
            targets: 5,
            render: function ( a, t, e, n )
            {
              var i = {
                0: {
                  title: "PENDING",
                  class: "m-badge--default"
                },
                1: {
                  title: "COMPLETED",
                  class: " m-badge--success"
                },
                2: {
                  title: "ON HOLD",
                  class: " m-badge--warning"
                },

              };
              if ( e.status == 1 )
              {
                if ( UID == 1 )
                {
                  return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusSaleInvoice(' + e.form_id + ',' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"
                } else
                {
                  return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="AchangeStatusSaleInvoice(' + e.form_id + ',' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"

                }


              } else
              {
                return void 0 === i[ a ] ? a : '<a href="javascript::void(0)" title="Change Status"  id=' + e.form_id + ' class="' + e.order_id + '" onclick="changeStatusSaleInvoice(' + e.form_id + ',' + e.RecordID + ')" ><span class="m-badge ' + i[ a ].class + ' m-badge--wide">' + i[ a ].title + "</span></a>"

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



//ApprovedForSAPINvoice
function ApprovedForSAPINvoice( formID, rowid )
{
  swal( {
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    type: "warning",
    showCancelButton: !0,
    confirmButtonText: "Yes,Proceed",
    cancelButtonText: "No, Cancel!",
    reverseButtons: !1
  } ).then( function ( ey )
  {
    if ( ey.value )
    {
      var oid = $( '#' + formID ).attr( 'class' );


      $( '#sirOID_A' ).html( oid );
      $( '#ReqID_A' ).val( rowid );
      $( '#m_modal_saleInvoiceResponceAdd_SAPApprval' ).modal( 'show' );


    }

  } )

}
//ApprovedForSAPINvoice


function DeleteSalesInvoiceDataD( rowid )
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
        url: BASE_URL + "/deleteReqInvoice",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), form_id: rowid },
        success: function ( resp )
        {

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
            swal( "Deleted!", "Your Invoice Requested has been deleted.", "success" ).then( function ( eyz )
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




function changeStatusSaleInvoice( formID, ReqID )
{
  var oid = $( '#' + formID ).attr( 'class' );
  $( '#sirOID' ).html( oid );
  $( '#ReqID' ).val( ReqID );
  $( '#m_modal_saleInvoiceResponceAdd' ).modal( 'show' );


}
//btnSubmitInvSubmitAM
$( '#btnSubmitInvSubmitAM' ).click( function ()
{

  var rowID = $( '#ReqID' ).val();
  var sirMessage = $( '#sirMessageAM' ).val();
  var sirRespStatus = $( "#sirRespStatus option:selected" ).val();


  // if ( sirMessage == "" )
  // {
  //   toasterOptions();
  //   toastr.error( 'Please Enter Message  ', 'Feeback' );
  //   return true;
  // }

  //ajax
  var formData = {
    'rowID': rowID,
    'sirMessage': sirMessage,
    'sirRespStatus': sirRespStatus,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/saveAccountResponseOnSInvoiceRequestFeedback',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Sumitted Successfully  ', 'Account Feedback' );

        $( '#m_modal_SalesInvoiceViewDetailsFeedback' ).modal( 'toggle' );


      }
    },
    dataType: 'json'
  } );
  //ajax


} );

//btnSubmitInvSubmitAM

//btnSubmitInvSubmit
$( '#btnSubmitInvSubmit' ).click( function ()
{

  var rowID = $( '#ReqID' ).val();
  var sirMessage = $( '#sirMessage' ).val();
  var sirRespStatus = $( "#sirRespStatus option:selected" ).val();


  // if ( sirMessage == "" )
  // {
  //   toasterOptions();
  //   toastr.error( 'Please Enter Message  ', 'Feeback' );
  //   return true;
  // }

  //ajax
  var formData = {
    'rowID': rowID,
    'sirMessage': sirMessage,
    'sirRespStatus': sirRespStatus,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/saveAccountResponseOnSInvoiceRequestFeedback',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Sumitted Successfully  ', 'Account Feedback' );

        $( '#m_modal_SalesInvoiceViewDetailsFeedback' ).modal( 'toggle' );


      }
    },
    dataType: 'json'
  } );
  //ajax


} );

//btnSIRSubmitSAP
$( '#btnSIRSubmitSAP' ).click( function ()
{
  var rowID = $( '#ReqID_A' ).val();
  var sirMessageSAP = $( '#sirMessageSAP' ).val();
  var txtPartyNo = $( '#txtPartyNo' ).val();



  if ( sirMessageSAP == "" )
  {
    toasterOptions();
    toastr.error( 'Please Enter Message  ', 'Account Response' );
    return true;
  }
  if ( txtPartyNo == "" )
  {
    toasterOptions();
    toastr.error( 'Please Enter Party No.  ', 'Account Response' );
    return true;
  }

  //ajax
  var formData = {
    'rowID': rowID,
    'sirMessageSAP': sirMessageSAP,
    'txtPartyNo': txtPartyNo,

    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/saveAccountResponseOnSInvoiceRequest_FORSAP_Invoivce',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Sumitted Successfully  ', 'Account Response' );

        $( '#m_modal_saleInvoiceResponceAdd_SAPApprval' ).modal( 'toggle' );


      }
    },
    dataType: 'json'
  } );
  //ajax


} );

//btnSIRSubmitSAP

//btnSubmitInvSubmit

$( '#btnSIRSubmit' ).click( function ()
{
  var rowID = $( '#ReqID' ).val();
  var sirMessage = $( '#sirMessage' ).val();
  var txtTallyNo = $( '#txtTallyNo' ).val();
  var sirRespStatus = $( "#sirRespStatus option:selected" ).val();
  var inv_type = $( 'input[name="inv_type"]:checked' ).val();





  if ( sirMessage == "" )
  {
    toasterOptions();
    toastr.error( 'Please Enter Message  ', 'Account Response' );
    return true;
  }
  if ( txtTallyNo == "" )
  {
    toasterOptions();
    toastr.error( 'Please Enter Tally No.  ', 'Account Response' );
    return true;
  }

  //ajax
  var formData = {
    'rowID': rowID,
    'inv_type': inv_type,
    'sirMessage': sirMessage,
    'txtTallyNo': txtTallyNo,
    'sirRespStatus': sirRespStatus,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/saveAccountResponseOnSInvoiceRequest',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Sumitted Successfully  ', 'Account Response' );

        $( '#m_modal_saleInvoiceResponceAdd' ).modal( 'toggle' );


      }
    },
    dataType: 'json'
  } );
  //ajax


} );

//oncreditLeadActionView
function oncreditLeadActionView( rowID )
{

  $( '#txtIDLead' ).val( rowID )

  $( '#m_modal_leadCreditDataINFO' ).modal( 'show' );


}

//oncreditLeadActionView

//orderEditActionView
function orderEditActionView( rowID )
{

  $( '#txtID' ).val( rowID )

  $( '#m_modal_orderEDITDataINFO' ).modal( 'show' );


}

//orderEditActionView

//viewTicketInfoV2
function viewTicketInfoV2( rowID )
{
  //alert(rowID);
  //ajax
  var formData = {
    'rowID': rowID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getTicketListDataInfoV2',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '#m_modal_OrderDetailTicket' ).modal( 'show' );
      $( '#oderDetailVie' ).html( res.HTML );

    }
  } );
}

//viewTicketInfoV2


function viewTicketInfo( rowID )
{
  //alert(rowID);
  //ajax
  var formData = {
    'rowID': rowID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getTicketListDataInfo',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      $( '#viewDataTICKETINFO' ).html( '' );
      var myPIC = $( '#myPIC' ).attr( 'src' );
      var myName = $( '#myName' ).html();




      $.each( res.user_data, function ( mykeydis, rowData )
      {
        $( '#viewDataTICKETINFO' ).html( `<div class="m-widget3 ajticketDiv">
        <div class="m-widget3__item">
          <div class="m-widget3__header">
            <div class="m-widget3__user-img">
              <img class="m-widget3__img" src="${ rowData.profile_pic }" alt="">
            </div>
            <div class="m-widget3__info">
              <span class="m-widget3__username">
             <strong> ${ rowData.name }</strong>
              </span><br>
              <span class="m-widget3__time">
              ${ rowData.ticket_ago } 
              <p><a href="javascript::void(0)" class="m-link m--font-boldest">
              ${ rowData.ticket_msg }
              </a></p>

              </span>
            </div>
            <span class="m-widget3__status m--font-info">
            <span class="m-badge m-badge--success m-badge--wide">
            ${ rowData.ticket_status }</span>
            </span>
          </div>

      
           
          </div>

          <input type="hidden" value="${ rowData.ticketid }" id="txtSupportTicketID" >

                        
                      
        </div>
        <div class="m-widget3">
        <div class="m-widget3__item">
        <div class="m-widget3__header">
          <div class="m-widget3__user-img">
            <img class="m-widget3__img" src="${ myPIC }" alt="">
          </div>
          <div class="m-widget3__info">
            <span class="m-widget3__username">
              ${ myName } 
              <div class="form-group m-form__group row">
           
              <div class="col-10">
                <input class="form-control m-input" type="text" id="txtReplay" placeholder="Add a comment" id="example-text-input">
              </div>
              <div class="col-2">
              <a href="javascript::void(0)" id="btnReplayNOW" style="margin-left:-26px;margin-top:1px" class="btn btn-primary m-btn m-btn--custom m-btn--icon">
                <span>
                <i class="flaticon-reply"></i>
                 Replay
                </span>
              </a>
              
            </div>

            </div>

            </span>
            
          </div>
          <span class="m-widget3__status m--font-info">
          
          </span>
        </div>
      
      </div>


        `);
      } );

      $.each( res.replay_data, function ( mykeydis, rowData4 )
      {
        $( '.ajticketDiv' ).append( `<div class="m-widget3__item">
        <div class="m-widget3__header">
          <div class="m-widget3__user-img">
            <img class="m-widget3__img" src="${ rowData4.profile_pic }" alt="">
          </div>
          <div class="m-widget3__info">
            <span class="m-widget3__username">
            <b>${ rowData4.name }</b>
            </span><br>
            <span class="m-widget3__time">
            ${ rowData4.time_ag }
              <p><a href="javascript::void(0)" class="m-link m--font-boldest">
              ${ rowData4.user_msg }
              </a></p>
            </span>
          </div>
         
        </div>
        
      </div>`);


      } );
      //console.log(res.replay_data);


      $( '#btnReplayNOW' ).click( function ()
      {

        var ticketid = $( '#txtSupportTicketID' ).val();
        var txtReplay = $( '#txtReplay' ).val();

        //ajax
        var formData = {
          'ticketid': ticketid,
          'txtReplay': txtReplay,
          '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
        };
        $.ajax( {
          url: BASE_URL + '/setReplayToTicket',
          type: 'POST',
          data: formData,
          success: function ( res )
          {
            if ( res.status == 1 )
            {
              //toasterOptions();
              var myPIC = $( '#myPIC' ).attr( 'src' );
              var myName = $( '#myName' ).html();
              $( '#txtReplay' ).val( '' );



              // toastr.success('Submitted Successfully  ', 'Ticket Support');
              $( '.ajticketDiv' ).append( `<div class="m-widget3__item">
                <div class="m-widget3__header">
                  <div class="m-widget3__user-img">
                    <img class="m-widget3__img" src="${ myPIC }" alt="">
                  </div>
                  <div class="m-widget3__info">
                    <span class="m-widget3__username">
                    <b>${ myName }</b>
                    </span><br>
                    <span class="m-widget3__time">
                      just now
                      <p><a href="javascript::void(0)" class="m-link m--font-boldest">
                      ${ txtReplay }
                      </a></p>
                    </span>
                  </div>
                 
                </div>
                
              </div>`);
              return true;
            }
          },
          dataType: 'json'
        } );
        //ajax



      } );


      $( '#m_modal_TicketDataINFO' ).modal( 'show' );

    },
    dataType: 'json'
  } );
  //ajax

}


//viewSalesInvoiceDataFeedback
function viewSalesInvoiceDataFeedback( rowID )
{

  //ajax
  $( '#ReqID' ).val( rowID );
  $( '#m_modal_SalesInvoiceViewDetailsFeedback' ).modal( 'show' );



}

//viewLeadonCreditData
function viewLeadonCreditData( rowID )
{
  //alert(rowID);
  //ajax
  var formData = {
    'rowID': rowID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getLeadOnCreditData',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '#m_modal_LeadOncreditView' ).modal( 'show' );
      $( '#viewLeadDataCreditViewReq' ).html( res.HTML_LIST );
    },
    dataType: 'json'
  } );
  //ajax

}

//viewLeadonCreditData

//viewSalesInvoiceDataFeedback

function viewSalesInvoiceData( rowID )
{
  //alert(rowID);
  //ajax
  var formData = {
    'rowID': rowID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getSalesInvoiceData',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '#m_modal_SalesInvoiceViewDetails' ).modal( 'show' );
      $( '#viewDataSaleInvReq' ).html( res.HTML_LIST );


      $(".txtNewQTy").focusout(function(){
      var currCal=$(this).val();
        // ajax 
        var formData = {
          'rowID': rowID,
          'currCal': currCal,
          '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
        };
        $.ajax( {
          url: BASE_URL + '/setUpdateQTY',
          type: 'POST',
          data: formData,
          success: function ( res )
          {
            toasterOptions();
            toastr.success( 'QTY Updated  ', 'QC Updation' );           

          }
        });

        // ajax 

        
      });
    },
    dataType: 'json'
  } );
  //ajax

}
// V1 order list

// m_table_salesInvoiceRequest

//admin View v2 Bulk order


var QCFROMLIST_V1ORDERLIST_ADMINVIEW_BulkOrder = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var buttonCommonORDER = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node )
            {
              // Strip $ from salary column to make it numeric
              //console.log(data);
              if ( UID != 1 )
              {
                return '';
              }
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




      a = $( "#m_table_QCFORMList_v1OrderListAdminView_BulkOrder" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [

          $.extend( true, {}, buttonCommonORDER, {
            extend: 'excelHtml5'
          } ),
          $.extend( true, {}, buttonCommonORDER, {
            extend: 'pdfHtml5'
          } )

        ],
        ajax: {

          url: BASE_URL + '/qcformOrderListAdminViewBulkOrders',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "pricePartStatus", "AccApproval", "stay_from", "order_type", "bulk_data", "bulkOrderValueData", "qc_from_bulk", "order_typeNew", "bulkCount", "curr_order_statge", "edit_qc_from", "order_value", "role_data", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "is_req_for_issue", "Actions" ],
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
            return 'NA';
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
            if ( e.AccApproval == 1 )
            {
              return 'PENDING';
            } else
            {
              return `<a href="javascript::void(0)" style="text-decoration:none" onclick="GeneralViewStage(${ process_id },${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;

            }





          }
        },
        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            //alert(UID);
            switch ( e.is_req_for_issue )
            {
              case 1:
                // code block
                var strReqS = 'Requested';
                break;
              case 2:
                var strReqS = 'Accepted';

                break;
              case 3:
                var strReqS = 'Hold';

                break;
              case 4:
                var strReqS = 'Rejected';

                break;
              case 5:
                var strReqS = 'Completed';

                break;

              default:
                var strReqS = '';
            }

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
              edit_URL = BASE_URL + '/qcform/bulk/' + e.form_id + '/edit';
            }
            copy_URL = BASE_URL + '/qcform/' + e.form_id + '/copy-order';
            var MyStyle = '';
            if ( e.AccApproval == 1 )
            {
              MyStyle = 'style="pointer-events:none"';
            }
            //console.log(e.qc_from_bulk);
            if ( UID == 146 )
            {
              var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>      
                    
                    <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a> 

                  </a>  <a href="javascript::void(0)" onclick="viewOrderPaymentAccount(${ e.form_id })" style="margin-bottom:3px" title="View Payment" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-wallet"></i>
                </a>`;
              if ( UID == 146 )
              {
                if ( e.is_req_for_issue == 0 )
                {
                  html += ` </a>  <a href="javascript::void(0)" onclick="reqForIssueOrderModel(${ e.form_id })" style="margin-bottom:3px" title="Approval for issue" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="fa fa-star"></i>
                  </a>                 
                        `;

                }
                html += ` </a>  <a href="javascript::void(0)" onclick="reqForIssueOrderModelHistory(${ e.form_id })" style="margin-bottom:3px" title="Approval for issue" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="fa fa-eye"></i>
                </a>                 
                      `;
                html += `${ strReqS }`;

              }



              return html;
            }

            if ( UID == 88 )
            {
              var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>      
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>   
                
                                   
                    `;
              return html;
            }

            if ( UID == 90 )
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle }href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( e.created_by == 'Pooja Gupta' )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `

              }


              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

              return html;
            }

            if ( UID == 147 || UID == 196 )
            {
              var html = `<a  ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                    <i class="la la-print"></i>
                                  </a>                    
                                 
                                 
                                 <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                                    <i class="la la-eye"></i>
                                  </a> 
                                  </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                                  <i class="la la-image"></i>
                                </a>                                   
                                   `;


              return html;
            }

            if ( UID == 85 )
            {
              var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                   
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>                                   
                     `;
              html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-edit"></i>
                   </a> `;

              return html;
            }

            if ( e.role_data == 'Staff' )
            {


              if ( UID == 102 )
              {

                var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-print"></i>
                      </a>                    
                     
                     
                     <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a> 
                      </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-image"></i>
                    </a> 
                    </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-copy"></i>
                  </a>                     
                       `;


                if ( e.curr_order_statge == 'Artwork Recieved' )
                {
                  html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-edit"></i>
                        </a> `;

                }
                if ( e.curr_order_statge != 'Artwork Recieved' )
                {



                } else
                {
                  html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-trash"></i>
                      </a>  `

                }



              } else
              {


                var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px" title="PRINT QC" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( UID == 8755 )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a> `;

              }

            }
            if ( e.role_data == 'Admin' )
            {
              var html = `<a   href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                    <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a>
                    <a href="javascript::void(0)" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a> 
                    <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-copy"></i>
                  </a>                     
                     `;
              if ( e.pricePartStatus == 1 )
              {
                html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="fa fa-rupee-sign"></i>
                        </a> `;
              }


            }



            if ( e.role_data == 'SalesUser' )
            {
              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                   
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                

                                      
                     `;
              if ( e.curr_order_statge == 'Artwork Recieved' )
              {
                html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `;

              }
              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a>  `

              }



            }
            if ( e.role_data == 'CourierTrk' )
            {
              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                    <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a> 
                  
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-copy"></i>
                </a> 
                    
                     `;

              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

            }


            if ( e.role_data == 'SalesHead' )
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle }href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( e.created_by == 'Pooja Gupta' )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `

              }


              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

              return html;

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
    }
  }
}();
//admin View v2 Bulk order
//admin View v2
//m_table_QCFORMList_v1OrderListStaffView
var QCFROMLIST_V1ORDERLIST_STAFFVIEW = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var buttonCommonORDER = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node )
            {
              // Strip $ from salary column to make it numeric
              //console.log(data);
              if ( UID != 1 )
              {
                return '';
              }
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




      a = $( "#m_table_QCFORMList_v1OrderListStaffView" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,
        lengthMenu: [ 5, 10, 25, 50, 100, 200, 2000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        dom: 'Blfrtip',
        buttons: [

          $.extend( true, {}, buttonCommonORDER, {
            extend: 'excelHtml5'
          } ),
          $.extend( true, {}, buttonCommonORDER, {
            extend: 'pdfHtml5'
          } )

        ],
        ajax: {

          url: BASE_URL + '/qcformOrderListAdminView',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "pricePartStatus", "AccApproval", "stay_from", "order_type", "bulk_data", "bulkOrderValueData", "qc_from_bulk", "order_typeNew", "bulkCount", "curr_order_statge", "edit_qc_from", "order_value", "role_data", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
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
            if ( UID == 1 )
            {
              return `<a href="javascript::void(0)" style="text-decoration:none" onclick="GeneralViewStage(${ process_id },${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;

            }

            if ( e.AccApproval == 1 )
            {
              return 'PENDING';
            } else
            {
              return `<a href="javascript::void(0)" style="text-decoration:none" onclick="GeneralViewStage(${ process_id },${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;

            }





          }
        },
        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {
             //
            salesLead_Invoice_URL = BASE_URL + '/lead-sales-invoce-request/' + e.form_id;


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
              edit_URL = BASE_URL + '/qcform/bulk/' + e.form_id + '/edit';
            }
            copy_URL = BASE_URL + '/qcform/' + e.form_id + '/copy-order';
            var MyStyle = '';
            if ( e.AccApproval == 1 )
            {
              MyStyle = 'style="pointer-events:none"';
            }
            //console.log(e.qc_from_bulk);
            if ( UID == 88 )
            {
              var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>      
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>   
                
                                   
                    `;
              return html;
            }


            if ( UID == 171 )
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle }href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( e.created_by == 'Pooja Gupta' )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `

              }



              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

              if ( e.pricePartStatus == 1 )
              {
                html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="fa fa-rupee-sign"></i>
                        </a> `;
              }


              return html;
            }

            if ( UID == 90 || UID == 171 ) //dddd
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle }href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>       
                  </a>  <a href="javascript::void(0)" onclick="viewOrderDataAccessListA(${ e.form_id })" style="margin-bottom:3px" title="Access Print" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-plus"></i>
                </a>          
                    
                     `;
              if ( e.created_by == 'Pooja Gupta' )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `

              }



              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

              if ( e.pricePartStatus == 1 )
              {
                html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="fa fa-rupee-sign"></i>
                        </a> `;
              }

              html += ` <a href="${ salesLead_Invoice_URL }"  style="margin-bottom:3px" title="Add Sales Invoice" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="la la-plus"></i>
             </a>  `;



              return html;
            }

            if ( UID == 85 || UID == 234 )
            {
              var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                   
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>                                   
                     `;
              html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-edit"></i>
                   </a> `;

              return html;
            }

            if ( UID == 91 )
            {
              var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                   
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>                                   
                     `;


              return html;
            }

            if ( e.role_data == 'Staff' )
            {


              if ( UID == 102 )
              {

                var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-print"></i>
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


                if ( e.curr_order_statge == 'Artwork Recieved' )
                {
                  html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-edit"></i>
                        </a> `;

                }
                if ( e.curr_order_statge != 'Artwork Recieved' )
                {



                } else
                {
                  html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-trash"></i>
                      </a>  `

                }



              } else
              {


                var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px" title="PRINT QC" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( UID == 8755 )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a> `;

              }

            }
            if ( e.role_data == 'Admin' )
            {
              var html = `<a   href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                    <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a>
                    <a href="javascript::void(0)" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a> 
                    <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-copy"></i>
                  </a>                     
                     `;
              if ( e.pricePartStatus == 1 )
              {
                html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="fa fa-rupee-sign"></i>
                        </a> `;
              }


            }



            if ( e.role_data == 'SalesUser' )
            {
              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                   
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                

                                      
                     `;
              if ( e.curr_order_statge == 'Artwork Recieved' )
              {
                html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `;

              }
              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a>  `

              }



            }
            if ( e.role_data == 'CourierTrk' )
            {
              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                    <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a> 
                  
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-copy"></i>
                </a> 
                    
                     `;

              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

            }


            if ( e.role_data == 'SalesHead' )
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle }href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( e.created_by == 'Pooja Gupta' )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `

              }


              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

              return html;

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
    }
  }
}();

//m_table_QCFORMList_v1OrderListStaffView

//m_table_QCFORMList_v1OrderListPlainList
var QCFROMLIST_V1ORDERLIST_OrderPlanVIEW = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;




      a = $( "#m_table_QCFORMList_v1OrderListPlainList" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,
        lengthMenu: [ 5, 10, 25, 50, 100, 200, 2000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,


        ajax: {

          url: BASE_URL + '/qcformOrderPlanOrderView',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "pricePartStatus",
              "AccApproval", "stay_from", "order_type",
              "bulk_data", "bulkOrderValueData",
              "qc_from_bulk", "order_typeNew",
              "bulkCount", "curr_order_statge",
              "edit_qc_from", "order_value",
              "role_data", "form_id", "order_id",
              "brand_name", "client_id", "order_repeat",
              "pre_order_id", "created_by", "created_on",
              "item_name",
              "orderUNIT",
              "orderBatchSize",
              "fillingType",
              "targetDate",
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
            data: "brand_name"
          },

          {
            data: "orderUNIT"
          },

          {
            data: "orderBatchSize"
          },
          {
            data: "fillingType"
          },

          {
            data: "created_by"
          },
          {
            data: "targetDate"
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
          targets: [ 0, ],
          visible: !1
        },




        {
          targets: -3,
          title: "Current Stages",
          orderable: !1,
          render: function ( a, t, e, n )
          {


            var process_id = 1;
            if ( UID == 1 )
            {
              return `<a href="javascript::void(0)" style="text-decoration:none" onclick="GeneralViewStage(${ process_id },${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;

            }

            if ( e.AccApproval == 1 )
            {
              return 'PENDING';
            } else
            {
              return `<a href="javascript::void(0)" style="text-decoration:none" onclick="GeneralViewStage(${ process_id },${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;

            }





          }
        },
        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {

            salesLead_Invoice_URL = BASE_URL + '/lead-sales-invoce-request/' + e.form_id;


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
              edit_URL = BASE_URL + '/qcform/bulk/' + e.form_id + '/edit';
            }
            copy_URL = BASE_URL + '/qcform/' + e.form_id + '/copy-order';
            var MyStyle = '';
            if ( e.AccApproval == 1 )
            {
              MyStyle = 'style="pointer-events:none"';
            }
            var html = `<a   href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                    <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a>
                    <a href="javascript::void(0)" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a> 
                    <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>                                     
                     `;
            if ( e.pricePartStatus == 1 )
            {
              html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="fa fa-rupee-sign"></i>
                        </a> `;
            }



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

//m_table_QCFORMList_v1OrderListPlainList


var QCFROMLIST_V1ORDERLIST_ADMINVIEW_PENDING = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var buttonCommonORDER = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node )
            {
              // Strip $ from salary column to make it numeric
              //console.log(data);
              if ( UID != 1 )
              {
                return '';
              }
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


//m_table_QCFORMList_v1OrderListAdminViewPending


      a = $( "#m_table_QCFORMList_v1OrderListAdminViewPending" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,
        lengthMenu: [ 5, 10, 25, 50, 100, 200, 2000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        dom: 'Blfrtip',
        buttons: [

          $.extend( true, {}, buttonCommonORDER, {
            extend: 'excelHtml5'
          } ),
          $.extend( true, {}, buttonCommonORDER, {
            extend: 'pdfHtml5'
          } )

        ],
        ajax: {

          url: BASE_URL + '/qcformOrderListAdminViewPending',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "pricePartStatus", "AccApproval", "stay_from", "order_type", "bulk_data", "bulkOrderValueData", "qc_from_bulk", "order_typeNew", "bulkCount", "curr_order_statge", "edit_qc_from", "order_value", "role_data", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
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
            if ( UID == 1 )
            {
              return `<a href="javascript::void(0)" style="text-decoration:none" onclick="GeneralViewStage(${ process_id },${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;

            }

            if ( e.AccApproval == 1 )
            {
              return 'PENDING';
            } else
            {
              return `<a href="javascript::void(0)" style="text-decoration:none" onclick="GeneralViewStage(${ process_id },${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;

            }





          }
        },
        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {

            salesLead_Invoice_URL = BASE_URL + '/lead-sales-invoce-request/' + e.form_id;


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
              edit_URL = BASE_URL + '/qcform/bulk/' + e.form_id + '/edit';
            }
            copy_URL = BASE_URL + '/qcform/' + e.form_id + '/copy-order';
            var MyStyle = '';
            if ( e.AccApproval == 1 )
            {
              MyStyle = 'style="pointer-events:none"';
            }
            //console.log(e.qc_from_bulk);
            if ( UID == 185 )
            {
              if ( e.pricePartStatus == 1 )
              {

                return `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="fa fa-rupee-sign"></i>
                          </a>`;
              } else
              {
                return '';
              }



            }

            if ( UID == 88 )
            {
              var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>      
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>   
                
                                   
                    `;
              return html;
            }


            if ( UID == 1714 )
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle }href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( e.created_by == 'Pooja Gupta' )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `

              }



              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

              if ( e.pricePartStatus == 1 )
              {
                html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="fa fa-rupee-sign"></i>
                        </a> `;
              }


              return html;
            }

            if ( UID == 90 || UID == 171 ) //dddd
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle }href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>       
                  </a>  <a href="javascript::void(0)" onclick="viewOrderDataAccessList(${ e.form_id })" style="margin-bottom:3px" title="Access Print" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>          
                    
                     `;
              if ( e.created_by == 'Pooja Gupta' )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `

              }



              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

              if ( e.pricePartStatus == 1 )
              {
                html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="fa fa-rupee-sign"></i>
                        </a> `;
              }

              html += ` <a href="${ salesLead_Invoice_URL }"  style="margin-bottom:3px" title="Add Sales Invoice" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="la la-plus"></i>
             </a>  `;

              html += ` <a href="javascript::void(0)" onclick="orderEditREQ(${ e.form_id })" style="margin-bottom:3px" title="Order Edit Request" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
             <i class="fa fa-hand-point-left"></i>
            </a>  `;



              return html;
            }
            if ( UID == 147 || UID == 196 || UID == 219 || UID==212 )
            {
              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                   
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>                                   
                     `;


              return html;
            }
            if ( UID == 85 )
            {
              var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                   
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>                                   
                     `;
              html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-edit"></i>
                   </a> `;

              return html;
            }

            if ( e.role_data == 'Staff' )
            {


              if ( UID == 102 )
              {

                var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-print"></i>
                      </a>                    
                     
                     
                     <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a> 
                      </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-image"></i>
                    </a> 
                    </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-copy"></i>
                  </a>                     
                       `;


                if ( e.curr_order_statge == 'Artwork Recieved' )
                {
                  html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-edit"></i>
                        </a> `;

                }
                if ( e.curr_order_statge != 'Artwork Recieved' )
                {



                } else
                {
                  html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-trash"></i>
                      </a>  `

                }



              } else
              {


                var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px" title="PRINT QC" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( UID == 8755 )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a> `;

              }

            }
            if ( e.role_data == 'Admin' )
            {
              var html = `<a   href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                    <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a>
                    <a href="javascript::void(0)" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a> 
                    <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-copy"></i>
                  </a>                     
                     `;
              if ( e.pricePartStatus == 1 )
              {
                html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="fa fa-rupee-sign"></i>
                        </a> `;
              }


            }



            if ( e.role_data == 'SalesUser' )
            {
              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                   
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                

                                      
                     `;
              if ( e.curr_order_statge == 'Artwork Recieved' )
              {
                html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `;

              }
              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a>  `

              }



            }
            if ( e.role_data == 'CourierTrk' )
            {
              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                    <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a> 
                  
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-copy"></i>
                </a> 
                    
                     `;

              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

            }


            if ( e.role_data == 'SalesHead' )
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle }href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( e.created_by == 'Pooja Gupta' )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `

              }


              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

              return html;

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
    }
  }
}();

var QCFROMLIST_V1ORDERLIST_ADMINVIEW = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var buttonCommonORDER = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node )
            {
              // Strip $ from salary column to make it numeric
              //console.log(data);
              if ( UID != 1 )
              {
                return '';
              }
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


//m_table_QCFORMList_v1OrderListAdminViewPending


      a = $( "#m_table_QCFORMList_v1OrderListAdminView" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,
        lengthMenu: [ 5, 10, 25, 50, 100, 200, 2000 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        dom: 'Blfrtip',
        buttons: [

          $.extend( true, {}, buttonCommonORDER, {
            extend: 'excelHtml5'
          } ),
          $.extend( true, {}, buttonCommonORDER, {
            extend: 'pdfHtml5'
          } )

        ],
        ajax: {

          url: BASE_URL + '/qcformOrderListAdminView',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "pricePartStatus", "AccApproval", "stay_from", "order_type", "bulk_data", "bulkOrderValueData", "qc_from_bulk", "order_typeNew", "bulkCount", "curr_order_statge", "edit_qc_from", "order_value", "role_data", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
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
            if ( UID == 1 )
            {
              return `<a href="javascript::void(0)" style="text-decoration:none" onclick="GeneralViewStage(${ process_id },${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;

            }

            if ( e.AccApproval == 1 )
            {
              return 'PENDING';
            } else
            {
              return `<a href="javascript::void(0)" style="text-decoration:none" onclick="GeneralViewStage(${ process_id },${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;

            }





          }
        },
        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {

            salesLead_Invoice_URL = BASE_URL + '/lead-sales-invoce-request/' + e.form_id;


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
              edit_URL = BASE_URL + '/qcform/bulk/' + e.form_id + '/edit';
            }
            
            copy_URL = BASE_URL + '/qcform/' + e.form_id + '/copy-order';
            var MyStyle = '';
            if ( e.AccApproval == 1 )
            {
              MyStyle = 'style="pointer-events:none"';
            }
            //console.log(e.qc_from_bulk);
            if ( UID == 185 )
            {
              if ( e.pricePartStatus == 1 )
              {

                return `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="fa fa-rupee-sign"></i>
                          </a>`;
              } else
              {
                return '';
              }



            }

            if ( UID == 88 )
            {
              var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>      
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>   
                
                                   
                    `;
              return html;
            }


            if ( UID == 1714 )
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle }href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( e.created_by == 'Pooja Gupta' )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `

              }



              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

              if ( e.pricePartStatus == 1 )
              {
                html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="fa fa-rupee-sign"></i>
                        </a> `;
              }


              return html;
            }

            if ( UID == 90 || UID == 171 ) //dddd
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle }href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>       
                  </a>  <a href="javascript::void(0)" onclick="viewOrderDataAccessList(${ e.form_id })" style="margin-bottom:3px" title="Access Print" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-eye"></i>
                </a>          
                    
                     `;
              if ( e.created_by == 'Pooja Gupta' )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `

              }



              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

              if ( e.pricePartStatus == 1 )
              {
                html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="fa fa-rupee-sign"></i>
                        </a> `;
              }

              html += ` <a href="${ salesLead_Invoice_URL }"  style="margin-bottom:3px" title="Add Sales Invoice" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
              <i class="la la-plus"></i>
             </a>  `;

              html += ` <a href="javascript::void(0)" onclick="orderEditREQ(${ e.form_id })" style="margin-bottom:3px" title="Order Edit Request" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
             <i class="fa fa-hand-point-left"></i>
            </a>  `;



              return html;
            }
            if ( UID == 147 || UID == 196 || UID == 219 || UID==212 )
            {
              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                   
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>                                   
                     `;


              return html;
            }
            if ( UID == 85 || UID == 234  )
            {
              var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                   
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a>                                   
                     `;
                     if ( e.pricePartStatus == 1 )
                     {
                       html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                             <i class="fa fa-rupee-sign"></i>
                               </a> `; 
                     }
                     html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `


              return html;
            }

            if ( e.role_data == 'Staff' )
            {


              if ( UID == 102 )
              {

                var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-print"></i>
                      </a>                    
                     
                     
                     <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a> 
                      </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-image"></i>
                    </a> 
                    </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-copy"></i>
                  </a>                     
                       `;


                if ( e.curr_order_statge == 'Artwork Recieved' )
                {
                  html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-edit"></i>
                        </a> `;

                }
                if ( e.curr_order_statge != 'Artwork Recieved' )
                {



                } else
                {
                  html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-trash"></i>
                      </a>  `

                }



              } else
              {


                var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px" title="PRINT QC" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( UID == 8755 )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a> `;

              }

            }
            if ( e.role_data == 'Admin' )
            {
              var html = `<a   href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                    <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a>
                    <a href="javascript::void(0)" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a> 
                    <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-copy"></i>
                  </a>                     
                     `;
              if ( e.pricePartStatus == 1 )
              {
                html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="fa fa-rupee-sign"></i>
                        </a> `;
              }


            }



            if ( e.role_data == 'SalesUser' )
            {
              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                   
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                

                                      
                     `;
              if ( e.curr_order_statge == 'Artwork Recieved' )
              {
                html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `;

              }
              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a>  `

              }



            }
            if ( e.role_data == 'CourierTrk' )
            {
              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                    <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a> 
                  
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-copy"></i>
                </a> 
                    
                     `;

              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

            }


            if ( e.role_data == 'SalesHead' )
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle }href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( e.created_by == 'Pooja Gupta' )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `

              }


              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

              return html;

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
    }
  }
}();
//admin View v2

//m_table_QCFORMList_v1OrderList_VIEWBYTEAM
var QCFROMLIST_V1ORDERLIST_VIEWBYTEAM = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var UserID = $( '#txtUserIDData' ).val();

      var buttonCommonORDER = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node )
            {
              // Strip $ from salary column to make it numeric
              //console.log(data);
              if ( UID != 1 )
              {
                return '';
              }
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





      a = $( "#m_table_QCFORMList_v1OrderList_VIEWBYTEAM" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [

          $.extend( true, {}, buttonCommonORDER, {
            extend: 'excelHtml5'
          } ),
          $.extend( true, {}, buttonCommonORDER, {
            extend: 'pdfHtml5'
          } )

        ],
        ajax: {

          url: BASE_URL + '/getOrderListForTeam',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "AccApproval", "stay_from", "order_type", "bulk_data", "bulkOrderValueData", "qc_from_bulk", "order_typeNew", "bulkCount", "curr_order_statge", "edit_qc_from", "order_value", "role_data", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
            'UserID': UserID
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
            if ( e.AccApproval == 1 )
            {
              return 'PENDING';
            } else
            {
              return `<a href="javascript::void(0)" style="text-decoration:none" onclick="GeneralViewStage(${ process_id },${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;

            }





          }
        },
        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            //return '';

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
              edit_URL = BASE_URL + '/qcform/bulk/' + e.form_id + '/edit';
            }
            copy_URL = BASE_URL + '/qcform/' + e.form_id + '/copy-order';
            var MyStyle = '';
            if ( e.AccApproval == 1 )
            {
              MyStyle = 'style="pointer-events:none"';
            }
            //console.log(e.qc_from_bulk);
            if ( UID == 88 )
            {
              var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                    `;
              return html;
            }

            if ( e.role_data == 'Staff' )
            {

              if ( UID == 102 )
              {

                var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-print"></i>
                      </a>                    
                     
                     
                     <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a> 
                      </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-image"></i>
                    </a> 
                    </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-copy"></i>
                  </a>                     
                       `;


                if ( e.curr_order_statge == 'Artwork Recieved' )
                {
                  html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-edit"></i>
                        </a> `;

                }
                if ( e.curr_order_statge != 'Artwork Recieved' )
                {



                } else
                {
                  html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-trash"></i>
                      </a>  `

                }



              } else
              {


                var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( UID == 8755 )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a> `;

              }

            }
            if ( e.role_data == 'Admin' )
            {
              var html = `<a   href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                    <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a>
                    <a href="javascript::void(0)" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a> 
                    <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-copy"></i>
                  </a> 
                    
                     `;
            }



            if ( e.role_data == 'SalesUser' )
            {
              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                   
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                

                                      
                     `;
              if ( e.curr_order_statge == 'Artwork Recieved' )
              {
                html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `;

              }
              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a>  `

              }



            }
            if ( e.role_data == 'CourierTrk' )
            {
              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                    <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a> 
                  
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-copy"></i>
                </a> 
                    
                     `;

              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

            }


            if ( e.role_data == 'SalesHead' )
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle }href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( e.created_by == 'Pooja Gupta' )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `

              }


              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }



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
    }
  }
}();

//m_table_QCFORMList_v1OrderList_VIEWBYTEAM

// V1 order list
var QCFROMLIST_V1ORDERLIST = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var buttonCommonORDER = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node )
            {
              // Strip $ from salary column to make it numeric
              //console.log(data);
              if ( UID != 1 )
              {
                return '';
              }
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


      //m_table_QCFORMList_v1OrderList_VIEWBYTEAM
      //m_table_QCFORMList_v1OrderList_VIEWBYTEAM
      if ( UID == 124 )
      {
        var URlM = BASE_URL + '/qcformGetList_v1_fast';

      } else
      {
        var URlM = BASE_URL + '/qcformGetList_v1';
      }

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
        dom: 'Blfrtip',
        buttons: [

          $.extend( true, {}, buttonCommonORDER, {
            extend: 'excelHtml5'
          } ),
          $.extend( true, {}, buttonCommonORDER, {
            extend: 'pdfHtml5'
          } )

        ],
        ajax: {

          url: URlM,
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "editByReqStatus", "dispatch_status", "price_part_status", "AccApproval", "stay_from", "order_type", "bulk_data", "bulkOrderValueData", "qc_from_bulk", "order_typeNew", "bulkCount", "curr_order_statge", "edit_qc_from", "order_value", "role_data", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
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
            if ( e.AccApproval == 1 )
            {
              return 'PENDING';
            } else
            {
              if ( e.dispatch_status == 2 )
              {
                return `<a href="javascript::void(0)" style="text-decoration:none" onclick="GeneralViewStage(${ process_id },${ e.form_id })"><h6 class="m--font-brand" title='View Details'>Partial </h6></a>`;

              } else
              {
                return `<a href="javascript::void(0)" style="text-decoration:none" onclick="GeneralViewStage(${ process_id },${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;

              }


            }





          }
        },
        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {

            salesLead_Invoice_URL = BASE_URL + '/lead-sales-invoce-request/' + e.form_id;

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
              edit_URL = BASE_URL + '/qcform/bulk/' + e.form_id + '/edit';
            }
            copy_URL = BASE_URL + '/qcform/' + e.form_id + '/copy-order';
            var MyStyle = '';
            if ( e.AccApproval == 1 )
            {
              MyStyle = 'style="pointer-events:none"';
            }

            if ( UID == 189 )
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle } href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>               
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  </a>  <a href="javascript::void(0)" onclick="viewOrderDataAccessList(${ e.form_id })" style="margin-bottom:3px" title="Access Print" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-plus"></i>
                </a> 
                                   
                    `;
              return html;
            }


            if ( UID == 124 )
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle }href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>               
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  </a>  <a href="javascript::void(0)" onclick="viewOrderDataAccessList(${ e.form_id })" style="margin-bottom:3px" title="Access Print" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-plus"></i>
                </a> 
                                   
                    `;
              return html;
            }

            if ( UID == 173 || UID == 132 || UID == 176 )
            {
              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                 
                   
                    <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                 
                    
                     `;
              return html;
            }
            //console.log(e.qc_from_bulk);
            if ( UID == 88 )
            {
              var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                    `;
              return html;
            }

            if ( e.role_data == 'Staff' )
            {

              if ( UID == 102 )
              {

                var html = `<a ${ MyStyle } href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-print"></i>
                      </a>                    
                     
                     
                     <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-eye"></i>
                      </a> 
                      </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-image"></i>
                    </a> 
                    </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-copy"></i>
                  </a>                     
                       `;


                if ( e.curr_order_statge == 'Artwork Recieved' )
                {
                  html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                          <i class="la la-edit"></i>
                        </a> `;

                }
                if ( e.curr_order_statge != 'Artwork Recieved' )
                {



                } else
                {
                  html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-trash"></i>
                      </a>  `

                }



              } else
              {


                var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( UID == 8755 )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a> `;

              }

            }
            if ( e.role_data == 'Admin' )
            {
              var html = `<a   href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                    <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a>
                    <a href="javascript::void(0)" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a> 
                    <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-copy"></i>
                  </a> 
                    
                     `;
            }



            if ( e.role_data == 'SalesUser' )
            {

              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>                    
                   
                   
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                

                                      
                     `;

              if ( e.curr_order_statge == 'Artwork Recieved' )
              {
                if ( e.AccApproval == 0 )
                {

                } else
                {
                  html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-edit"></i>
                </a> `;
                }


              }
              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a>  `

              }

              if ( e.price_part_status == 1 )
              {
                html += ` <a href="javascript::void()" onclick="ModifyOrderDetailsRequest(${ e.form_id })" style="margin-bottom:3px" title="Modify Request FORM" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="fa fa-rupee-sign"></i>
              </a>  `
              }
              if ( e.editByReqStatus == 1 )
              {
                html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                <i class="la la-edit"></i>
              </a> `
              }








            }
            if ( e.role_data == 'CourierTrk' )
            {
              var html = `<a ${ MyStyle }  href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    
                    <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a> 
                  
                   <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    </a>  <a href="javascript::void(0)" onclick="viewOrderDataIMG(${ e.form_id })" style="margin-bottom:3px" title="View Packaging" class="btn btn-accent m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-image"></i>
                  </a> 
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-copy"></i>
                </a> 
                    
                     `;

              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }

            }


            if ( e.role_data == 'SalesHead' )
            {
              var myID = 'boOrdID' + e.form_id;

              var html = `<a ${ MyStyle }href="${ print_URL }" id="${ myID }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
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
              if ( e.created_by == 'Pooja Gupta' )
              {
                html += `<a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="la la-edit"></i>
                      </a> `

              }


              if ( e.curr_order_statge != 'Artwork Recieved' )
              {



              } else
              {
                html += ` <a href="javascript::void()" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px" title="Delete" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                     <i class="la la-trash"></i>
                   </a>  `

              }



            }

            html += ` <a href="${ salesLead_Invoice_URL }"  style="margin-bottom:3px" title="Add Sales Invoice" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-plus"></i>
           </a>  `;


            html += ` <a href="javascript::void(0)" onclick="orderEditREQ(${ e.form_id })" style="margin-bottom:3px" title="Order Edit Request" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
           <i class="fa fa-hand-point-left"></i>
          </a>  `;

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


// V1 order list

var QCFROMLIST = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
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




      a = $( "#m_table_QCFORMList" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [

          $.extend( true, {}, buttonCommonORDER, {
            extend: 'excelHtml5'
          } ),
          $.extend( true, {}, buttonCommonORDER, {
            extend: 'pdfHtml5'
          } )

        ],
        ajax: {

          url: BASE_URL + '/qcform.getList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "order_type", "bulk_data", "bulkOrderValueData", "qc_from_bulk", "order_typeNew", "bulkCount", "curr_order_statge", "edit_qc_from", "order_value", "role_data", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
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
            console.log( e.bulk_data );
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
          targets: 5,
          title: "Order Value",
          orderable: !0,
          render: function ( a, t, e, n )
          {
            // console.log(e);
            if ( e.role_data == 'Admin' || e.role_data == 'SalesUser' )
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
            return `<a href="javascript::void(0)" style="text-decoration:none" onclick="showmeMyStatge(${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;


          }
        },
        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          width: 200,
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
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-copy"></i>
                  </a> 
                    
                     `;
            }
            if ( e.role_data == 'SalesUser' || e.role_data == 'CourierTrk' )
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
                  </a>  <a href="#"  style="margin-bottom:3px" title="Copy Order" class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                  <i class="la la-copy"></i>
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
    }
  }
}();


var QCFROMLIST_BULK = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      var buttonCommonORDER = {
        exportOptions: {
          format: {
            body: function ( data, row, column, node )
            {
              // Strip $ from salary column to make it numeric
              //console.log(data);
              if ( UID != 1 )
              {
                return '';
              }

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
      if ( UID == 199 )
      {
        var URLX = BASE_URL + '/qcformOrderListAdminViewBulkOrders';
      } else
      {
        var URLX = BASE_URL + '/qcformgetListBulk';
      }
      a = $( "#m_table_QCFORMListBulk" ).DataTable( {
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
        dom: 'Blfrtip',
        buttons: [

          $.extend( true, {}, buttonCommonORDER, {
            extend: 'excelHtml5'
          } ),
          $.extend( true, {}, buttonCommonORDER, {
            extend: 'pdfHtml5'
          } )

        ],
        ajax: {

          url: URLX,
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "order_type", "bulk_data", "bulkOrderValueData", "qc_from_bulk", "order_typeNew", "bulkCount", "curr_order_statge", "edit_qc_from", "order_value", "role_data", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "is_req_for_issue", "Actions" ],
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
            data: "Actions"
          }
        ],

        columnDefs: [ {
          targets: [ 0 ],
          visible: !1
        },
        {
          targets: 4,
          title: "Item Name",
          orderable: !0,
          render: function ( a, t, e, n )
          {
            console.log( e.bulk_data );
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
          targets: 5,
          title: "Order Value",
          orderable: !0,
          render: function ( a, t, e, n )
          {
            // console.log(e);
            if ( e.role_data == 'Admin' || e.role_data == 'SalesUser' )
            {
              if ( e.order_typeNew == 1 )
              {
                return e.bulkOrderValueData;
              } else
              {
                return e.order_value;
              }


            } else
            {
              return 'NA';
            }

          }
        },
        {
          targets: -2,
          title: "Current Stages",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            return `<a href="javascript::void(0)" style="text-decoration:none" onclick="showmeMyStatge(${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;


          }
        },
        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            //alert(UID);
            switch ( e.is_req_for_issue )
            {
              case 1:
                // code block
                var strReqS = 'Requested';
                break;
              case 2:
                var strReqS = 'Accepted';

                break;
              case 3:
                var strReqS = 'Hold';

                break;
              case 4:
                var strReqS = 'Rejected';

                break;
              case 5:
                var strReqS = 'Completed';

                break;

              default:
                var strReqS = '';
            }

            console.log( e.qc_from_bulk );
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
            edit_URL = '#';


            var html = `<a href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a> 
                    <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-eye"></i>
                  </a>
                    `;

            if ( UID == 199 )
            {
              if ( e.is_req_for_issue >= 0 && e.is_req_for_issue <= 3 )
              {
                html += ` </a>  <a href="javascript::void(0)" onclick="reqForIssueOrderModel(${ e.form_id })" style="margin-bottom:3px" title="Action on Request" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                        <i class="fa fa-star"></i>
                      </a>                 
                            `;
                html += ` </a>  <a href="javascript::void(0)" onclick="reqForIssueOrderModelHistory(${ e.form_id })" style="margin-bottom:3px" title="Approval for issue" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                            <i class="fa fa-eye"></i>
                          </a>                 
                                `;
                html += `${ strReqS }`
              }
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
    }
  }
}();


//dispatched
var QCFROMLIST_DISPATCHED = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_QCFORMList_dispatched" ).DataTable( {
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

          url: BASE_URL + '/qcform_getList_dispatched',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "order_type", "pricePartStatus", "dispatched_status", "dispatched_for", "dispatch_details", "dispatched_on", "curr_order_statge", "edit_qc_from", "order_value", "role_data", "form_id", "order_id", "brand_name", "client_id", "order_repeat", "pre_order_id", "created_by", "created_on", "item_name", "Actions" ],
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
            data: "dispatched_for"
          },
          {
            data: "dispatched_on"
          },

          {
            data: "Actions"
          }
        ],

        columnDefs: [ {
          targets: [ 0 ],
          visible: !1
        },
        {
          targets: 5,
          title: "Order Value",
          orderable: !0,
          render: function ( a, t, e, n )
          {


            if ( UID == 147 || e.role_data == 'Admin' || e.role_data == 'SalesUser' || e.role_data == 'SalesHead' )
            {
              if ( UID == 88 || UID == 147 || UID == 146 )
              {

                return 'NA';

              } else
              {
                return '<i class="fa fa-rupee-sign"></i> ' + e.order_value;
              }


            } else
            {
              return 'NA';
            }

          }
        },
        {
          targets: -2,
          title: "Dispatched on",
          orderable: !1,
          width: 200,
          render: function ( a, t, e, n )
          {
            //console.log(e.dispatch_details);
            // var HTML=``;
            // HTML +=`<a href="javascript::void(0)" style="text-decoration:none" onclick="showmeMyStatgeWithDispatch(${e.form_id})"><h6 class="m--font-brand" title='View Details'> <br>
            // <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">${e.dispatched_on}</span>
            // </h6></a>`;
            // if(dispatched_status==2){
            //   HTML +=`<a href="javascript::void(0)" style="text-decoration:none" onclick="showmeMyStatgeWithDispatch(${e.form_id})"><h6 class="m--font-brand" title='View Details'> <br>
            //   <span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Partial Dispatched</span>
            //   </h6></a>`;
            // }
            // return HTML;

            var html = `<a href="javascript::void(0)" title="info" class="btn btn-accent m-btn m-btn--icon" onclick="showmeMyStatgeWithDispatch(${ e.form_id })">
              ${ e.dispatched_on }
            </a>
            `;
            if ( e.dispatched_status == 2 )
            {
              html += `<a style="margin-top:2px;" href="javascript::void(0)" onclick="againDispatchOrder(${ e.form_id })"
                  title="Add Feedback" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                                             <i class="flaticon-reply"></i>
                                             </a>`;
            }



            return html;





          }
        },
        {
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {

            edit_URL = BASE_URL + '/qcform/' + e.form_id + '/edit';
            manageOrder_URL = BASE_URL + '/order-wizard/' + e.form_id;

            if ( e.order_type == 'Private Label' )
            {
              print_URL = BASE_URL + '/print/qcform/' + e.form_id;
            } else
            {
              print_URL = BASE_URL + '/print/qcform-bulk/' + e.form_id;
            }
            view_URL = BASE_URL + '/sample/' + e.RecordID + '';

            copy_URL = BASE_URL + '/qcform/' + e.form_id + '/copy-order';

            if ( e.role_data == 'SalesUser' )
            {
              var html = `
            <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
            <i class="la la-eye"></i>
          </a>
            `;
              if ( e.pricePartStatus == 1 )
              {
                html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="fa fa-rupee-sign"></i>
                      </a> `;
              }



              return html;


            }


            if ( UID == 88 || UID == 147 || UID == 146 || UID == 219 || UID == 249 )
            {
              return `<a href="${ print_URL }" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-print"></i>
                    </a>`;
            }
            if ( e.role_data == 'Staff' || UID == 90 || UID == 171 )
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
                     `;

              }
              if ( UID == 87 )
              {
                html += ` <a href="${ edit_URL }"  style="margin-bottom:3px" title="EDIT" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit"></i>
                    </a> `;
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
                    <a href="${ manageOrder_URL }" title="Manage Order" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="flaticon-interface-3"></i>
                    </a> 
                    <a href="javascript::void(0)" onclick="sfotDeleteOrder(${ e.form_id })" style="margin-bottom:3px"  title="PRINT"  target="_balck" class="btn btn-danger m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-trash"></i>
                    </a> 
                    <a href="javascript::void(0)" onclick="viewOrderData(${ e.form_id })" style="margin-bottom:3px" title="View Details" class="btn btn-info m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-eye"></i>
                    </a> 
                    <a href="#"  style="margin-bottom:3px" title="Copy Order " class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="la la-copy"></i>
                  </a> 
                    
                     `;
            }
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
                     <a href="#"  style="margin-bottom:3px" title="Copy Order " class="btn btn-success m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-copy"></i>
                    </a> 
                    
                     `;
            }
            if ( e.pricePartStatus == 1 )
            {
              html += `</a>  <a href="javascript::void(0)"  onclick="viewOrderDataPricePart(${ e.form_id })"    style="margin-bottom:3px" title="Price breakup" class="btn btn-warning m-btn m-btn--icon btn-sm m-btn--icon-only">
                    <i class="fa fa-rupee-sign"></i>
                      </a> `;
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
    }
  }
}();


//dispatched



//order statge Report
var OrderStageReport_1 = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_OrderStageReport_1" ).DataTable( {
        responsive: !0,
        // scrollY: "50vh",
        scrollX: !0,
        scrollCollapse: !0,

        lengthMenu: [ 5, 10, 25, 50, 100 ],
        pageLength: 120,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getOrderStatgesReport',
          type: "POST",
          data: {
            columnsDef: [ "sale_person", "pending_count", "order_data" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [
          {
            data: "sale_person"
          },
          {
            data: "pending_count"
          },
          {
            data: "order_data"
          }
        ],


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

//order statge Report

var QCFROM_PURCHASE_EDIT_HITORY_LIST = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_ListOFUpdatedBOM" ).DataTable( {
        responsive: !0,
        //dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
        lengthMenu: [ 50, 100, 500 ],
        pageLength: 50,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getPurchaseListHistory',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "item_name", "order_id", "order_item_name", "category", "qty", "Status" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [ {
          data: "RecordID"
        }, {
          data: "item_name"
        }, {
          data: "order_id"
        }, {
          data: "order_item_name"
        }, {
          data: "category"
        }, {
          data: "qty"
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
          targets: -1,
          title: "Actions",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            return ''
          }
        }, {
          targets: 6,
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
                title: "ORDER RECIEVED",
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
  QCFROM_PURCHASE_EDIT_HITORY_LIST.init()
} );


jQuery( document ).ready( function ()
{
  DatatablesSearchOptionsAdvancedSearchSampleDataList.init();
  DatatablesSearchOptionsAdvancedSearchSampleDataList_feedbackown.init();
  DatatablesSearchOptionsAdvancedSearchSampleDataList_LITE.init();
  DatatablesSearchOptionsAdvancedSearchSampleDataList_LITE_HISTORY.init();
  DatatablesSearchOptionsAdvancedSearchSampleDataList_LITE_OILS.init();
  DatatablesSearchOptionsAdvancedSearchSampleDataList_LITE_COSMATIC.init();
  DatatablesSearchOptionsAdvancedSearchSampleDataList_LITE_COSMATIC_oilView.init();
  DatatablesSearchOptionsAdvancedSearchSampleDataListV2Formulation.init();
  DatatablesSearchOptionsAdvancedSearchSampleDataListV2FormulationSalesList.init();

  DatatablesSalesDashSampleDataList.init();
  DatatablesSalesDashSampleDataListPendingAprroval.init();
  DatatablesSalesDashOrderDataList_technicalDocuement.init();
  DatatablesSalesDashSampleDataList_technicalDocuement.init();
  DatatablesDataSourceAjaxServerFAQList.init();
  DatatablesSalesDashTeamViews.init();
  SampleDataListNEW.init()
  SampleListUserwise.init()
  PaymentRequestLIST.init()
  QCFROMLIST.init()
  DatatablesaIngedenentList.init()
  DatatablesaIngedients.init()
  DatatablesaIngedientsPrice.init()
  DatatablesaIngedientsPrice.initAB()
  DatatablesaIngedientsPrice.initABBASE()
  DatatablesaIngedientsPrice.initABBASE_FROM()
  DatatablesaIngedientsPrice.initABC()
  DatatablesaIngedenentBrandList.init()
  DatatablesaIngedenentCategoryList.init()
  DatatableRNDFinishProductList.init()
  QCFROMLIST_TICKETLISTUSER.init()
  QCFROMLIST_TICKETV2.init()
  QCFROMLIST_OrderEditLISTUSER.init()
  QCFROMLIST_LeadCompter.init()
  QCFROMLIST_ActivityLISTUSER.init()
  DatatableRNDFinishProductList_salesDash.init()
  QCFROMLIST_BULK.init()
  QCFROM_PURCHASE_LIST.init();
  QCFROM_PURCHASE_LIST_BOV1.init();
  QCFROM_PURCHASE_LIST_BOV1_AJ.init();
  QCFROM_PRODUCTION_LIST.init()
  OrderStageReport_1.init()
  QCFROMLISTStagePendingList.init()
  QCFROMLIST_DISPATCHED.init()
  QCFROMLIST_CLIENTORDER.init()
  QCFROMLIST_V1ORDERLIST.init()
  QCFROMLIST_V1ORDERLIST_VIEWBYTEAM.init()

  QCFROMLIST_V1ORDERLIST_ADMINVIEW.init()
  QCFROMLIST_V1ORDERLIST_ADMINVIEW_PENDING.init()
  QCFROMLIST_V1ORDERLIST_OrderPlanVIEW.init()
  QCFROMLIST_V1ORDERLIST_STAFFVIEW.init()
  QCFROMLIST_V1ORDERLIST_ADMINVIEW_BulkOrder.init()
  QCFROMLIST_V1SALEINOCIELIST.init()
  QCFROMLIST_V1SALEINOCIELIST_HIST.init()
  QCFROMLIST_V1_ONCREDITLEAD.init()
  QCFROMLIST_V1ORDERLISTAccess.init()
  QCFROMLIST_V1PAYMENTLIST_HIST.init()

  DatatableNewProductDevelopment.init();
  DatatableFinishProductCatList.init();
  DatatableFinishProductSubCatList.init();
  QCFROM_PURCHASE_LIST_BOV1_BOX_LABEL.init();
  QCFROM_PURCHASE_LIST_BOV1_BOX_LABEL_V1.init();



  //QCFROM_PURCHASE_EDIT_HITORY_LIST.init();

} );




// showmeMyStatge
function showmeMyStatgeWithDispatch( form_id )
{

  //console.log(arr_dispatched_data);
  var formData = {
    'form_id': form_id,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getCurrentOrderStagesData',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      var qc_data = res.qc_data;
      var created_at = qc_data.created_at;
      var new_dateOS = moment( created_at ).format( 'LLLL' )
      $( '#txtOSOrderID' ).html( qc_data.order_id + '/' + qc_data.subOrder );
      $( '#txtOSBrandName' ).html( qc_data.brand_name );
      $( '#txtOSItemName' ).html( qc_data.item_name );
      $( '#txtOSRecivedON' ).html( new_dateOS );
      var order_statge_arr = res.order_stages;
      var qc_dispatched = res.qc_dispatched;
      //var dispatch_by=res.dispatch_by;
      var orderStageList = res.order_stagesList;
      //console.log(orderStageList[0].orderSteps);
      // return false;
      //console.log(orderStageList[0].orderSteps);
      //console.log(qc_dispatched);

      $( '.aj_orderViewData' ).html( "" );
      $.each( order_statge_arr, function ( key, val )
      {

        $( '.aj_orderViewData' ).append( `<div class="m-widget6__item">
          <span class="m-widget6__text">
           ${ val.statgeName }
          </span>
          <span class="m-widget6__text">
          ${ val.completed_on }
          </span>
          <span class="m-widget6__text m--align-right m--font-boldest m--font-brand">
          ${ val.completed_by }
          </span>
        </div>`);
      } );

      //order steps 
      $( '.aj_statges_individual' ).html( "" );

      $( '.ajshowdispatch' ).html( "" );
      var BOHTML = '';
      var icount = 0;
      $.each( qc_dispatched, function ( mykeydis, myvaldis )
      {
        //$('.ajshowdispatch').append('44');
        console.log( myvaldis );


        switch ( myvaldis.dispatch_by )
        {


          case 88:
            day_dispatch = "";
            break;
          case 85:
            day_dispatch = "Jyoti Bajaj";
            break;
          case 90:
            day_dispatch = "Puja Gupta";
            break;
          case 146:
            day_dispatch = "Ajay Yadav";
            break;
          default:
            day_dispatch = "NA";

        }
        day_dispatch = '';

        BOHTML += `<tr>ssss       
        <td>LR No:</td>       
        <td>${ myvaldis.lr_no }</td>
        </tr>
        <tr>       
        <td>Transport :</td>       
        <td>${ myvaldis.transport }</td>
        </tr>
        <tr>       
        <td>Cartons :</td>       
        <td>${ myvaldis.cartons }</td>
        </tr>

        <tr>       
        <td>Unit in each carton :</td>       
        <td>${ myvaldis.unit_in_each_carton }</td>
        </tr>

        <tr>       
        <td>Total Unit :</td>       
        <td>${ myvaldis.total_unit }</td>
        </tr>

        <tr>       
        <td>Booking For  :</td>       
        <td>${ myvaldis.txtBookingFor }</td>
        </tr>

        <tr>       
        <td>Invoice  :</td>       
        <td>${ myvaldis.txtInvoice }</td>
        </tr>

        <tr>       
        <td>Dispatched on  :</td>       
        <td>${ myvaldis.dispatch_on }</td>
        </tr>

          <tr>       
          <td>Due Unit   :</td>       
          <td>${ myvaldis.dueUnit }</td>
          </tr>
          <tr>       
          <td>Dispatched By   :</td>       
          <td>${ day_dispatch }</td>
          </tr>

          <tr>
          <td colspan="2">
          <hr style="color:#035496">
          </td>
          </tr>






        `;


      } );
      $( '.ajshowdispatch' ).append( BOHTML );

      var qc_dispatched5 = [];
      $.each( qc_dispatched5, function ( mykeydis, myvaldis )
      {


        icount++;
        if ( mykeydis == 'lr_no' )
        {


          $( '.ajshowdispatch' ).append( `<tr>
       
        <td>LR No:</td>       
        <td>${ myvaldis }</td>
        </tr>`);
        }
        if ( mykeydis == 'transport' )
        {
          $( '.ajshowdispatch' ).append( `<tr>       
        <td>Transport :</td>       
        <td>${ myvaldis }</td>
        </tr>`);
        }

        if ( mykeydis == 'cartons' )
        {
          $( '.ajshowdispatch' ).append( `<tr>       
        <td>Cartons :</td>       
        <td>${ myvaldis }</td>
        </tr>`);
        }
        if ( mykeydis == 'unit_in_each_carton' )
        {
          $( '.ajshowdispatch' ).append( `<tr>       
        <td>Unit in each carton :</td>       
        <td>${ myvaldis }</td>
        </tr>`);
        }
        if ( mykeydis == 'total_unit' )
        {
          $( '.ajshowdispatch' ).append( `<tr>       
        <td>Total Unit :</td>       
        <td>${ myvaldis }</td>
        </tr>`);
        }
        if ( mykeydis == 'txtBookingFor' )
        {
          $( '.ajshowdispatch' ).append( `<tr>       
        <td>Booking For  :</td>       
        <td>${ myvaldis }</td>
        </tr>`);
        }
        if ( mykeydis == 'txtInvoice' )
        {
          $( '.ajshowdispatch' ).append( `<tr>       
        <td>Invoice  :</td>       
        <td>${ myvaldis }</td>
        </tr>`);
        }
        if ( mykeydis == 'dispatch_on' )
        {
          $( '.ajshowdispatch' ).append( `<tr>       
        <td>Dispatched on  :</td>       
        <td>${ myvaldis }</td>
        </tr>`);
        }
        if ( mykeydis == 'dueUnit' )
        {
          if ( myvaldis > 0 )
          {
            $( '.ajshowdispatch' ).append( `<tr>       
          <td>Due Unit   :</td>       
          <td>${ myvaldis }</td>
          </tr>`);

          } else
          {
            $( '.ajshowdispatch' ).append( `<tr>       
              <td>Due Unit   :</td>       
              <td>More ${ myvaldis } </td>
              </tr>`);

          }

        }




      } );


      var pday = 0;
      $.each( orderStageList[ 0 ].orderSteps, function ( mykey, myval )
      {
        console.log( myval.process_days );



        pday = parseInt( pday ) + parseInt( myval.process_days );
        var new_date = moment( orderStageList[ 0 ].artwork_start_date, "YYYY-MM-DD" ).add( pday, 'days' ).format( "DD MMM" );
        var expected_date = moment( orderStageList[ 0 ].artwork_start_date, "YYYY-MM-DD" ).add( pday, 'days' ).format( "YYYY-MM-DD" );
        if ( parseInt( myval.next_STEP ) > 1 )
        {
          new_date_ = new_date
        } else
        {
          new_date_ = "";
        }

        var stepD = 0;
        if ( parseInt( myval.step_done ) == 1 )
        {
          stepD = 1;
        }
        var aj_class = myval.order_step + 'Aj' + myval.order_form_id;
        $( '.aj_statges_individual' ).append( ` 
        <li id="${ aj_class }" class="${ myval.color_code }"   >
                        <a href="javascript::void(0)"onclick="taskModalOrderList(${ myval.order_form_id },${ myval.order_step },'${ myval.process_name }',${ myval.process_days },'${ expected_date }',${ stepD },'${ myval.step_code }','no@email.com',${ qc_data.item_qty })" style="text-decoration-line:none"> 
                                                  <span  class="bubble"></span>
                                                ${ myval.process_name }<br>
                                                ${ new_date_ } 
                                                  </a>
                        </li>
       
    `);
      } );
      //order steps 

      $( '#m_modal_4_showOrderStagesData' ).modal( 'show' );

    },
    dataType: 'json'
  } );



}

//GeneralViewStageSAMPLING_Fv2
function GeneralViewStageSAMPLING_Fv2( process_id, ticket_id )
{

  //ajax call
  var formData = {
    'sampleID': ticket_id,
    'process_id': process_id,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getSampleStagesF',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      //   alert(44);
      $( '.ajcustomProgessBar' ).html( `` );
      //   $( '.ajorderTable' ).html( `<tr>
      //   <th scope="row">Order ID:<b>${ res.process_data.order_id }/${ res.process_data.subOrder }</b></th>
      //   <td>Brand Name:<b>${ res.process_data.brand_name }</b></td>
      //   <td>Sales Person:<b>${ res.created_by }</b></td>
      //   <td>Order Started: <b>${ res.artwork_start_date }</b></td>
      // </tr>`);

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
            HTML += `<a  style="backdround:red" class="active" href="javascript::void(0)" onclick="StageActionWithDetailsRND_FV2(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name }</a>`;

          } else
          {
            HTML += `<a  style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetailsRND_FV2(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name }</a>`;

          }
        } else
        {
          if ( st.stage_id == 1 && st.stage_access_status == 1 )
          {
            HTML += `<a  data-toggle="m-tooltip" data-placement="top" title="Default light skin" style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetailsRND_FV2(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name }</a>`;

          } else
          {
            HTML += `<a data-toggle="m-tooltip" data-placement="top" title="Default light skin"  style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetailsRND_FV2(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount }${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name } </a>`;

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
//GeneralViewStageSAMPLING_Fv2

//GeneralViewStageSAMPLING
function GeneralViewStageSAMPLING( process_id, ticket_id )
{

  //ajax call
  var formData = {
    'sampleID': ticket_id,
    'process_id': process_id,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getSampleStages',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      //   alert(44);
      $( '.ajcustomProgessBar' ).html( `` );
      //   $( '.ajorderTable' ).html( `<tr>
      //   <th scope="row">Order ID:<b>${ res.process_data.order_id }/${ res.process_data.subOrder }</b></th>
      //   <td>Brand Name:<b>${ res.process_data.brand_name }</b></td>
      //   <td>Sales Person:<b>${ res.created_by }</b></td>
      //   <td>Order Started: <b>${ res.artwork_start_date }</b></td>
      // </tr>`);

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

//GeneralViewStageSAMPLING

// 
function GeneralViewStageRND( process_id, ticket_id )
{
  //alert(ticket_id);
  //ajax call
  var formData = {
    'form_id': ticket_id,
    'process_id': process_id,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getAllOrderStagev1_rnd',
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
      <td></td>
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
// GeneralViewStageRND
// GeneralViewStage
function GeneralViewStage( process_id, ticket_id )
{
  //alert(ticket_id);
  //ajax call
  var formData = {
    'form_id': ticket_id,
    'process_id': process_id,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getAllOrderStagev1',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      // console.log(res.BOM_HTML);
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
    <td></td>
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
            HTML += `<a  style="backdround:red" class="active" href="javascript::void(0)" onclick="StageActionWithDetails(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name } ${ st.artwork_start_date }</a>`;

          } else
          {
            HTML += `<a  style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetails(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name } ${ st.artwork_start_date }</a>`;

          }
        } else
        {
          if ( st.stage_id == 1 && st.stage_access_status == 1 )
          {
            HTML += `<a  data-toggle="m-tooltip" data-placement="top" title="Default light skin" style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetails(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name } </a>`;

          } else
          {
            HTML += `<a data-toggle="m-tooltip" data-placement="top" title="Default light skin"  style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetails(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount }${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name } </a>`;

          }
        }


      } );

      $( '.ajcustomProgessBar' ).append( HTML );
      $( '#bomVieAw' ).html( '' );

      $( '#bomVieAw' ).append( res.BOM_HTML );


      $( '#m_modal_1_2_GeneralViewModel' ).modal( 'show' );

    },
    dataType: 'json'
  } );
  //ajax call

}
//GeneralViewStage
//StageActionWithDetailsRND_FV2
function StageActionWithDetailsRND_FV2( process_id, stage_id, ticket_id, stage_access, form_id, rowCount, dependent_ticket, itmqty )
{

  if ( stage_access == 0 )
  {
    toasterOptions();
    toastr.error( 'Access Denied  ', 'Stage Process' );
    return true;
  }
  if ( stage_id == 4 )
  {
    var stateg_Tile = "Packaging Stage";
    $( '#model_BO_task_61_1' ).modal( 'show' );
  }

  if ( stage_id == 3 )
  {

    //ajax 
    var form_id_1 = 61;
    var formData = {
      'sample_id': ticket_id,
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };

    $.ajax( {
      url: BASE_URL + '/getSampleItemDetailFormulation',
      type: 'POST',
      data: formData,
      success: function ( res )
      {

        $( '.sampleItemView' ).html( "" );
        $( '.sampleICode' ).html( "" );

        $( '#txtStage_ID' ).val( stage_id );
        $( '#txtTicketID' ).val( ticket_id );
        $( '#txtProcessID' ).val( process_id );
        $( '#txtRowCount' ).val( rowCount );
        $( '#txtDependentTicketID' ).val( dependent_ticket );

        var formid = "#model_BO_task_" + form_id_1;
        $( formid ).modal( 'show' );
        $( '.sampleICode' ).html( res.sid );
        $( '#txtSIDValueFv2' ).val( res.sid );
        $.each( res.data, function ( key, val )
        {
          $( '.sampleItemView' ).append( `<div class="form-group m-form__group row">
      <div class="col-lg-3" >
      <input type="hidden" name="txtSID" value="${ ticket_id }">
      <input type="hidden" name="sitemID[]" value="${ val.sitemID }">

          <label style="color:#FFF"  class="form-control-label">*Key Ingredient:(${ val.sample_subCode })</label>                  
          <textarea style="visibility:hidden" class="form-control m-input" name="txtIngredent[]" id=""></textarea>
          <span style="color:#FFF">Item Name:${ val.sample_item }</span>
          <input type="hidden" name="txtSampleIDPart[]" value="${ val.sample_subCode }">
          <input type="hidden"  name="txtSampleItemName[]" value="${ val.sample_item }">
      </div>
      <div class="col-lg-2">
          <label style="color:#FFF" class="form-control-label">* Fragrance:</label>
          <input type="text" name="txtFragrance[]" class="form-control m-input" placeholder="" value="${ val.sample_fragrance }">
      </div>
      <div class="col-lg-2">
          <label style="color:#FFF" class="form-control-label">* Color :</label>
          <input type="text" name="txtColor[]" class="form-control m-input" placeholder="" value="${ val.sample_color }">
      </div>
      <div class="col-lg-1">
          <label style="color:#FFF" class="form-control-label">* PH:</label>
          <input type="text" name="txtPHValue[]" class="form-control m-input" placeholder="" value="">
      </div>
      <div class="col-lg-2">
          <label style="color:#FFF" class="form-control-label">* Apperance:</label>
          <input type="text" name="txtAppearance[]" class="form-control m-input" placeholder="" value="">
      </div>
      <div class="col-lg-2">
          <label style="color:#FFF" class="form-control-label">* Chemist:</label>
         ${ res.sHTML }
      </div>
  </div><hr style="border-top: 1px solid grey;">`);
        } );

      }
    } );
    //ajax 
  }









}

//StageActionWithDetailsRND_FV2


// StageActionWithDetailsRND
function StageActionWithDetailsRND( process_id, stage_id, ticket_id, stage_access, form_id, rowCount, dependent_ticket, itmqty )
{

  //-----------------
  if ( process_id == 6 )
  {
    if ( UID == 1247 )
    {
      toasterOptions();
      toastr.error( 'Access Denied  ', 'Stage Process' );
      return true;
    }
    if ( stage_access == 0 )
    {
      toasterOptions();
      toastr.error( 'Access Denied  ', 'Stage Process' );
      return true;
    }
    if ( stage_access == 1 )
    {
      if ( form_id == 51 )
      {

        //ajax 
        var formData = {
          'sample_id': ticket_id,
          '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
        };
        $.ajax( {
          url: BASE_URL + '/getSampleItemDetail',
          type: 'POST',
          data: formData,
          success: function ( res )
          {
            $( '.sampleItemView' ).html( "" );
            $( '.sampleICode' ).html( "" );

            $( '#txtStage_ID' ).val( stage_id );
            $( '#txtTicketID' ).val( ticket_id );
            $( '#txtProcessID' ).val( process_id );
            $( '#txtRowCount' ).val( rowCount );
            $( '#txtDependentTicketID' ).val( dependent_ticket );

            var formid = "#model_BO_task_" + form_id;
            $( formid ).modal( 'show' );
            $( '.sampleICode' ).html( res.sid );
            $( '#txtSIDValue' ).val( ticket_id );
            $.each( res.data, function ( key, val )
            {
              $( '.sampleItemView' ).append( `<div class="form-group m-form__group row">
              <div class="col-lg-3" >
                  <label style="color:#FFF"  class="form-control-label">*Key Ingredient:(${ val.sample_subCode })</label>                  
                  <textarea style="visibility:hidden" class="form-control m-input" name="txtIngredent[]" id=""></textarea>
                  <span style="color:#FFF">Item Name:${ val.sample_item }</span>
                  <input type="hidden" name="txtSampleIDPart[]" value="${ val.sample_subCode }">
                  <input type="hidden"  name="txtSampleItemName[]" value="${ val.sample_item }">
              </div>
              <div class="col-lg-2">
                  <label style="color:#FFF" class="form-control-label">* Fragrance:</label>
                  <input type="text" name="txtFragrance[]" class="form-control m-input" placeholder="" value="">
              </div>
              <div class="col-lg-2">
                  <label style="color:#FFF" class="form-control-label">* Color :</label>
                  <input type="text" name="txtColor[]" class="form-control m-input" placeholder="" value="">
              </div>
              <div class="col-lg-1">
                  <label style="color:#FFF" class="form-control-label">* PH:</label>
                  <input type="text" name="txtPHValue[]" class="form-control m-input" placeholder="" value="">
              </div>
              <div class="col-lg-2">
                  <label style="color:#FFF" class="form-control-label">* Apperance:</label>
                  <input type="text" name="txtAppearance[]" class="form-control m-input" placeholder="" value="">
              </div>
              <div class="col-lg-2">
                  <label style="color:#FFF" class="form-control-label">* Chemist:</label>
                 ${ res.sHTML }
              </div>
          </div><hr style="border-top: 1px solid grey;">`);
            } );

          }
        } );
        //ajax 


      } else
      {
        $( '#txtStage_ID' ).val( stage_id );


        $( '#txtTicketID' ).val( ticket_id );
        $( '#txtProcessID' ).val( process_id );
        $( '#txtRowCount' ).val( rowCount );
        $( '#txtDependentTicketID' ).val( dependent_ticket );

        var formid = "#model_BO_task_" + form_id;
        $( formid ).modal( 'show' );
      }
    }

  }


  if ( stage_access == 0 )
  {
    toasterOptions();
    toastr.error( 'Access Denied  ', 'Stage Process' );
    return true;
  }
  if ( stage_access == 1 )
  {
    //  alert(itmqty);
    $( '#txtStage_ID' ).val( stage_id );


    $( '#txtTicketID' ).val( ticket_id );
    $( '#txtProcessID' ).val( process_id );
    $( '#txtRowCount' ).val( rowCount );
    $( '#txtDependentTicketID' ).val( dependent_ticket );

    var formid = "#model_BO_task_" + form_id;
    $( formid ).modal( 'show' );

  }

}


// StageActionWithDetailsRND



function StageActionWithDetails( process_id, stage_id, ticket_id, stage_access, form_id, rowCount, dependent_ticket, itmqty )
{


  //------------------
  if ( stage_id == 13 && process_id == 1 )
  {
    $( '#txtOrderID_FORMI_v1' ).val( ticket_id );
    var formData = {
      'ticket_id': ticket_id,
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    $.ajax( {
      url: BASE_URL + '/getOrderQty',
      type: 'POST',
      data: formData,
      success: function ( res )
      {
        console.log( res );
        // alert(res);
        $( '#GtxtTotalOrderUnit' ).val( res );
      }
    } );

  }
  //------------------


  if ( stage_access == 0 )
  {
    toasterOptions();
    toastr.error( 'Access Denied  ', 'Stage Process' );
    return true;
  }
  if ( stage_access == 1 )
  {
    //  alert(itmqty);
    $( '#txtStage_ID' ).val( stage_id );


    $( '#txtTicketID' ).val( ticket_id );
    $( '#txtProcessID' ).val( process_id );
    $( '#txtRowCount' ).val( rowCount );
    $( '#txtDependentTicketID' ).val( dependent_ticket );

    var formid = "#model_BO_task_" + form_id;
    $( formid ).modal( 'show' );

  }



}


//btnStageProcessCompletedNow
$( '#btnStageProcessCompletedNowd' ).click( function ()
{
  //ajax call
  var formData = {
    'txtStage_ID': $( '#txtStage_ID' ).val(),
    'txtTicketID': $( '#txtTicketID' ).val(),
    'txtProcessID': $( '#txtProcessID' ).val(),
    'txtProcessID': $( '#txtProcessID' ).val(),
    'txtRemarks': $( '#message-text' ).val(),
    'action_on': 1,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/setSaveProcessAction',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      if ( res.status == 0 )
      {
        toasterOptions();
        toastr.error( res.msg, 'Stage Process' );
        return false;

      } else
      {
        toasterOptions();
        toastr.success( res.msg, 'Stage Process' );
        //location.reload();
        $( '#model_BO_task_12' ).modal( 'hide' );

      }
    },
    dataType: 'json'
  } );

  //ajax call

} );


//btnStageProcessCompletedNow
$( '#btnGenCommentDone' ).click( function ()
{
  alert( 454 );
  //ajax call
  var formData = {
    'txtStage_ID': $( '#txtStage_ID' ).val(),
    'txtTicketID': $( '#txtTicketID' ).val(),
    'txtProcessID': $( '#txtProcessID' ).val(),
    'txtProcessID': $( '#txtProcessID' ).val(),
    'txtRemarks': $( '#message-text' ).val(),
    'action_on': 0,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/setSaveProcessAction',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      if ( res.status == 0 )
      {
        toasterOptions();
        toastr.error( res.msg, 'Stage Process' );
        return false;

      } else
      {
        toasterOptions();
        toastr.success( res.msg, 'Stage Process' );
        //location.reload();
        $( '#model_BO_task_12' ).modal( 'hide' );

      }
    },
    dataType: 'json'
  } );

  //ajax call
} );




//btnStageProcessCompletedNow
$( '#btnStageProcessCommentNow' ).click( function ()
{

  //ajax call
  var formData = {
    'txtStage_ID': $( '#txtStage_ID' ).val(),
    'txtTicketID': $( '#txtTicketID' ).val(),
    'txtProcessID': $( '#txtProcessID' ).val(),
    'txtProcessID': $( '#txtProcessID' ).val(),
    'txtRemarks': $( '#message-text' ).val(),
    'action_on': 0,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/setSaveProcessAction',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      if ( res.status == 0 )
      {
        toasterOptions();
        toastr.error( res.msg, 'Stage Process' );
        return false;

      } else
      {
        toasterOptions();
        toastr.success( res.msg, 'Stage Process' );
        location.reload();
        $( '#model_BO_task_12' ).modal( 'hide' );

      }
    },
    dataType: 'json'
  } );

  //ajax call
} );

function smartForm( form_id )
{
  if ( form_id )
  {
    alert( 6 );
  }
}

// showmeMyStatge
function showmeMyStatge( form_id )
{
  var formData = {
    'form_id': form_id,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getCurrentOrderStagesData',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      var qc_data = res.qc_data;
      var BOM_HTML = res.BOM_HTML;

      var created_at = qc_data.created_at;
      var new_dateOS = moment( created_at ).format( 'LLLL' )
      $( '#txtOSOrderID' ).html( qc_data.order_id + '/' + qc_data.subOrder );
      $( '#txtOSBrandName' ).html( qc_data.brand_name );
      $( '#txtOSItemName' ).html( qc_data.item_name );
      $( '#txtOSRecivedON' ).html( new_dateOS );
      var order_statge_arr = res.order_stages;
      var orderStageList = res.order_stagesList;
      //console.log(orderStageList[0].orderSteps);
      $( '#m_tabs_1_2_bomDetails' ).html( "" );
      $( '#m_tabs_1_2_bomDetails' ).html( BOM_HTML );

      $( '.aj_orderViewData' ).html( "" );
      $.each( order_statge_arr, function ( key, val )
      {

        $( '.aj_orderViewData' ).append( `<div class="m-widget6__item">
          <span class="m-widget6__text">
           ${ val.statgeName }
          </span>
          <span class="m-widget6__text">
          ${ val.completed_on }
          </span>
          <span class="m-widget6__text m--align-right m--font-boldest m--font-brand">
          ${ val.completed_by }
          </span>
        </div>`);
      } );

      //order steps 
      $( '.aj_statges_individual' ).html( "" );


      var pday = 0;
      $.each( orderStageList[ 0 ].orderSteps, function ( mykey, myval )
      {
        console.log();


        pday = parseInt( pday ) + parseInt( myval.process_days );
        var new_date = moment( orderStageList[ 0 ].artwork_start_date, "YYYY-MM-DD" ).add( pday, 'days' ).format( "DD MMM" );
        var expected_date = moment( orderStageList[ 0 ].artwork_start_date, "YYYY-MM-DD" ).add( pday, 'days' ).format( "YYYY-MM-DD" );
        if ( parseInt( myval.next_STEP ) > 1 )
        {
          new_date_ = new_date
        } else
        {
          new_date_ = "";
        }

        var stepD = 0;
        if ( parseInt( myval.step_done ) == 1 )
        {
          stepD = 1;
        }
        var aj_class = myval.order_step + 'Aj' + myval.order_form_id;
        $( '.aj_statges_individual' ).append( ` 
        <li id="${ aj_class }" class="${ myval.color_code }">
                        <a href="javascript::void(0)"onclick="taskModalOrderList(${ myval.order_form_id },${ myval.order_step },'${ myval.process_name }',${ myval.process_days },'${ expected_date }',${ stepD },'${ myval.step_code }','no@email.com',${ qc_data.item_qty })" style="text-decoration-line:none"> 
                                                  <span  class="bubble"></span>
                                                ${ myval.process_name }<br>
                                                ${ new_date_ } 
                                                  </a>
                        </li>
       
    `);
      } );
      //order steps 

      $( '#m_modal_4_showOrderStagesData' ).modal( 'show' );

    },
    dataType: 'json'
  } );



}
// showmeMyStatge
function taskModalOrderList( orderid, step_id, orderString, process_days, expected_date, stepdoneStatus, step_code, client_email, Qty )
{



  $( '#txtClientEmail' ).val( client_email );
  //alert(stepdoneStatus);
  //alert(Qty);
  $( '#txtTotalOrderUnit' ).val( Qty );

  $( '#txtTotalOrderUnit' ).attr( 'readonly', 'true' ); // mark it as read only


  if ( stepdoneStatus == 0 )
  {
    $( '#txtOrderStep' ).val( "STEP :" + step_id );
    $( '#txtorderStepID' ).val( step_id );
    $( '#txtProcess_days' ).val( process_days );
    $( '#txtProcess_Name' ).val( orderString );
    $( '#txtStepCode' ).val( step_code );

    $( '#txtOrderID_FORMID' ).val( orderid );
    $( '#expectedDate' ).val( expected_date );
    $( '#orderString' ).html( orderString );


    $( '#txtOrderStep1' ).val( "STEP :" + step_id );
    $( '#txtorderStepID1' ).val( step_id );
    $( '#txtProcess_days1' ).val( process_days );
    $( '#txtProcess_Name1' ).val( orderString );
    $( '#txtStepCode1' ).val( step_code );

    $( '#txtOrderID_FORMID1' ).val( orderid );
    $( '#expectedDate1' ).val( expected_date );
    $( '#orderString1' ).html( orderString );


    if ( orderString == 'Dispatch Order' )
    {
      //$('#dispatch_div').show();
      $( '#dispatch_div' ).hide();
      $( '#m_modal_5_orderDispatch' ).modal( 'show' );

    } else
    {
      $( '#dispatch_div' ).hide();
      // alert('one');
      $( '#m_modal_5_orderComment' ).modal( 'show' );
    }

  } else
  {

    var formDataSubmit = {
      'orderid': orderid,
      'step_id': step_id,
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
    };
    $.ajax( {
      url: BASE_URL + '/getOrderProcessSteps',
      type: 'POST',
      data: formDataSubmit,
      success: function ( res )
      {




        $( '#strTitle' ).html( orderString );
        var htmlA = '';
        htmlA += `<div class="m-demo">
        <div class="m-demo__preview">
          <div class="m-list-timeline">
            <div class="m-list-timeline__items">`;

        $.each( res.data, function ( key, data )
        {
          //console.log();
          var expected_date = moment( data.expected_date, "YYYY-MM-DD" ).format( "Do MMM" );
          var process_date = moment( data.process_date, "YYYY-MM-DD" ).format( "Do MMM" );
          var co_stat = "";
          if ( data.color_code == 'completed' )
          {
            co_stat = "success";
          }
          if ( data.color_code == 'danger' )
          {
            co_stat = "danger";
          }
          if ( data.status == 1 )
          {
            htmlA += `<div class="m-list-timeline__item">
              <span class="m-list-timeline__badge m-list-timeline__badge--${ co_stat }"></span>
              
              <span class="m-list-timeline__text">${ process_date } <b>${ orderString }</b> 
              <br>
              <b>Expect</b>:${ expected_date }
              </span>
              <span class="m-list-timeline__time">Comment:<strong>${ data.remaks }</strong></span>
             
              
            </div>`;
          } else
          {
            htmlA += `<div class="m-list-timeline__item">
              <span class="m-list-timeline__badge m-list-timeline__badge--${ co_stat }"></span>
              <span class="m-list-timeline__text">Comment:<strong>${ data.remaks }</strong></span>
             
              <span class="m-list-timeline__time"> Commented on: ${ data.created_at }</span>
            </div>`;
          }



        } );
        htmlA += ` </div>
                 </div>
                </div>
              </div>`;

        $( '#showProDateHere' ).html( htmlA );



        $( '#m_modal_5_orderCommentDisplay' ).modal( 'show' );


        if ( res.status == 0 )
        {
          toastr.success( 'Successfully added Comment', 'Order Process Wizard' );
          location.reload( 1 );

        }
      },
      dataType: 'json'
    } );


  }



}
//statge 


//datagrid Client list
//viewOrderDataPricePart
function viewOrderDataPricePart( rowid )
{
  var formData = {
    'rowid': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getQCFormOrderDataPricePart',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      if ( res.qc_dataPrice )
      {
        $( '#item_RM_Price' ).val( res.qc_dataPriceReq.item_RM_Price );
        $( '#item_BCJ_Price' ).val( res.qc_dataPriceReq.item_BCJ_Price );
        $( '#item_Label_Price' ).val( res.qc_dataPriceReq.item_Label_Price );
        $( '#item_Material_Price' ).val( res.qc_dataPriceReq.item_Material_Price );
        $( '#item_LabourConversion_Price' ).val( res.qc_dataPriceReq.item_LabourConversion_Price );
        $( '#item_Margin_Price' ).val( res.qc_dataPriceReq.item_Margin_Price );
        $( '#item_qty' ).val( res.qc_dataPriceReq.item_qty );
        $( '#item_selling_price' ).val( res.qc_dataPriceReq.item_sp );
        $( '#item_size' ).val( res.qc_dataPriceReq.item_size );
        $( '#order_value' ).val( res.qc_dataPriceReq.orderVal );

        item_RM_Price

      }
      //item_RM_Price

      //item_RM_Price
      if ( UID == 185 )
      {
        $( '.viewPricePart' ).html( `<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">      
      <tbody>        
      <th scope="row">7</th>
        <td>QTY: </td>
        <td>${ res.qc_dataPrice.item_qty }</td>        
      </tr>
      <th scope="row">8</th>
        <td>Selling Price: </td>
        <td>${ res.qc_dataPrice.item_sp }</td>        
      </tr>
      <th scope="row">9</th>
        <td><b>Order Values</b> </td>
        <td> ₹ <b style="color:#035496">${ res.qc_dataPrice.orderVal }</b></td>        
      </tr>   
            </tbody>
          </table>`);

      } else
      {
        $( '.viewPricePart' ).html( `<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
      
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td> RM Price/Kg: </td>
            <td>${ res.qc_dataPrice.item_RM_Price }</td>          
          </tr>
          <tr>
          <th scope="row">2</th>
          <td> Bottle/Cap/Pump: </td>
          <td>${ res.qc_dataPrice.item_BCJ_Price }</td>         
        </tr>
        <tr>
        <th scope="row">3</th>
        <td> Label Price: </td>
        <td>${ res.qc_dataPrice.item_Label_Price }</td>       
      </tr>
      <tr>
      <th scope="row">4</th>
      <td> M.Carton Price: </td>
      <td>${ res.qc_dataPrice.item_Material_Price }</td>         
    </tr>
    <tr>
    <th scope="row">5</th>
    <td>L & C Price: </td>
    <td>${ res.qc_dataPrice.item_LabourConversion_Price }</td>        
  </tr>
  <th scope="row">6</th>
    <td>Margin: </td>
    <td>${ res.qc_dataPrice.item_Margin_Price }</td>        
  </tr>
  
  <th scope="row">7</th>
    <td>QTY: </td>
    <td>${ res.qc_dataPrice.item_qty }</td>        
  </tr>
  <th scope="row">8</th>
    <td>Selling Price: </td>
    <td>${ res.qc_dataPrice.item_sp }</td>        
  </tr>
  <th scope="row">9</th>
    <td><b>Order Values</b> </td>
    <td> ₹ <b style="color:#035496">${ res.qc_dataPrice.orderVal }</b></td>        
  </tr>
  
  
          
        </tbody>
      </table>`);

      }

      $( '#m_modal_4_showQCFormPricePart' ).modal( 'show' );
    }
  } );


}

//viewOrderDataPricePart

function viewOrderData( rowid )
{
  var formData = {
    'rowid': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getQCFormOrderData',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      UUID = $( 'meta[name="UUID"]' ).attr( 'content' );
      UNIB = $( 'meta[name="UNIB"]' ).attr( 'content' );


      $( '#txtOrderId' ).html( res.qc_data.order_id );
      $( '#txtOrderType' ).html( res.qc_data.order_type );
      $( '#txtSalesPerson' ).html( res.qc_data.sales_person );
      $( '#txtBrandName' ).html( res.qc_data.brand_name );
      $( '#txtItemName' ).html( res.qc_data.item_name );

      $( '#txtClientName' ).html( res.qc_data.client_name );
      if ( UUID == 98 || UUID == 95 || UUID == 83 || UNIB == 'Admin' || UNIB == 'SalesUser' || UNIB == 'SalesHead' )
      {
        $( '#txtClientEmail' ).html( res.qc_data.client_email );
        $( '#txtClientPhone' ).html( res.qc_data.client_phone );
        // ajcode
        $( '#txtClientCompany' ).html( res.qc_data.client_company );
        $( '#txtClientGSTNO' ).html( res.qc_data.client_gstno );
        $( '#txtClientAddress' ).html( res.qc_data.client_address );

        // ajcode

      } else
      {
        $( '#txtClientEmail' ).html( 'N/A' );
        $( '#txtClientPhone' ).html( 'N/A' );
      }


      $( '#txtOrderRepeat' ).html( res.qc_data.order_repeat );

      $( '#txtFmS' ).html( res.qc_data.fms );

      
      
      if(res.qc_data_MoreStatus=='Bulk'){
        $( '#txtSize' ).html( '' );
        $( '#txtQty' ).html('' );
  
  
        $( '#txtSP' ).html( '' );
  
        $( '#txtOrderFor' ).html( '' );
      }else{
        $( '#txtSize' ).html( res.qc_data.size );
        $( '#txtQty' ).html( res.qc_data.qty );
  
  
        $( '#txtSP' ).html( res.qc_data.sp );
  
        $( '#txtOrderFor' ).html( res.qc_data.orderFor );
      }

     

      $( '#txtFragrance' ).html( res.qc_data.fragrance );


      if ( !res.qc_data.sp_view )
      {
        $( '#txtSP' ).html( 'N/A' );

      }
      if ( UNIB == 'Admin' || UNIB == 'SalesUser' || UNIB == 'SalesUser' )
      {
        $( '#txtOrderval' ).html( res.qc_data.orderVal );
      } else
      {
        $( '#txtOrderval' ).html( 'N/A' );
      }

      

            $(".moreDataQC").html(res.qc_data_MoreData);



      $( '#m_modal_4_showQCFormData' ).modal( 'show' );
    },
    dataType: 'json'
  } );


}

function viewOrderDataIMG( rowid )
{
  var formData = {
    'rowid': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getQCFormOrderData',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      console.log( res );
      var IMGURL = BASE_URL + "/" + res.qc_data.img_url;

      $( '#m_modal_4_showQCFormDataIMG' ).modal( 'show' );
      $( '#MyIMGSHOW' ).html( `<img src="${ IMGURL }">` );
    },
    dataType: 'json'

  } );

}
//ModifyOrderDetailsRequest
function ModifyOrderDetailsRequest( rowid )
{

  $( '#order_idModify' ).val( rowid );
  $( '#m_modal_4_ViewOrderDetailRequest' ).modal( 'show' );
  //ajax 
  $.ajax( {
    url: BASE_URL + "/getQCDataForModify",
    type: 'POST',
    data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), form_id: rowid },
    success: function ( res )
    {



      $( '#item_size' ).val( res.order_data.item_size );
      $( '#itemSizeUnitModify' ).val( res.order_data.item_size_unit );
      $( '#item_qty' ).val( res.order_data.item_qty );
      $( '#item_RM_Price' ).val( res.order_data.item_RM_Price );
      $( '#item_BCJ_Price' ).val( res.order_data.item_BCJ_Price );
      $( '#item_Label_Price' ).val( res.order_data.item_Label_Price );
      $( '#item_Material_Price' ).val( res.order_data.item_Material_Price );
      $( '#item_LabourConversion_Price' ).val( res.order_data.item_LabourConversion_Price );
      $( '#item_Margin_Price' ).val( res.order_data.item_Margin_Price );
      $( '#item_selling_price' ).val( res.order_data.item_sp );
      $( '#order_valueA' ).val();


    },
    dataType: "json"
  }
  );
  //ajax 

}
//ModifyOrderDetailsRequest
//sfotDeleteOrderTechDoc

//UserActivateTemp
function UserActivateTemp( rowid )
{
  swal( {
    title: "Are you sure?",
    text: "You want to authozie to login in ERP Today only",
    type: "warning",
    showCancelButton: !0,
    confirmButtonText: "Today Only Login  ",
    cancelButtonText: "No, Cancel!",
    reverseButtons: !1
  } ).then( function ( ey )
  {

    if ( ey.value )
    {
      $.ajax( {
        url: BASE_URL + "/ActivatUserMAC",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), rowid: rowid,forToday:2 },
        success: function ( resp )
        {

          if ( resp.status == 0 )
          {
            swal( "Activation Alert!", "Cann't not activate", "error" ).then( function ( eyz )
            {
              if ( eyz.value )
              {
                //location.reload();
              }
            } );
          } else
          {
            swal( "Activation!", "User successfully activated", "success" ).then( function ( eyz )
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

//UserActivateTemp

//UserActivate
function UserActivate( rowid )
{
  swal( {
    title: "Are you sure?",
    text: "You want to authozie to login in ERP",
    type: "warning",
    showCancelButton: !0,
    confirmButtonText: "Permanent",
    cancelButtonText: "No, Cancel!",
    reverseButtons: !1
  } ).then( function ( ey )
  {
  

  
    if ( ey.value )
    {
      $.ajax( {
        url: BASE_URL + "/ActivatUserMAC",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), rowid: rowid,forToday:1 },
        success: function ( resp )
        {

          if ( resp.status == 0 )
          {
            swal( "Activation Alert!", "Cann't not activate", "error" ).then( function ( eyz )
            {
              if ( eyz.value )
              {
                //location.reload();
              }
            } );
          } else
          {
            swal( "Activation!", "User successfully activated", "success" ).then( function ( eyz )
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
//UserActivate


function UserDelleteSoft( rowid )
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
        url: BASE_URL + "/deleteUserSoft",
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
                //location.reload();
              }
            } );
          } else
          {
            swal( "Deleted!", "User successfully deleted", "success" ).then( function ( eyz )
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



function sfotDeleteOrderTechDoc( rowid )
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
        url: BASE_URL + "/deleteSampleTechDoc",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), form_id: rowid },
        success: function ( resp )
        {

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
            swal( "Deleted!", "Your Doc has been deleted.", "success" ).then( function ( eyz )
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

//sfotDeleteOrderTechDoc
//orderEditREQ
function orderEditREQ( rowid )
{
  //ajax
  var formData = {
    'rowid': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getQCFormOrderData',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      var data = res.qc_data;
      $( '#txtFORMI' ).val( rowid );
      $( '.orderDetailsViD' ).html( `<table class="table table-bordered m-table m-table--border-brand m-table--head-bg-brand">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Brand</th>         
          <th>Created on</th>
          <th>Sample</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">${ data.order_id } <b>(${ data.order_type })</b></th>
          <td>${ data.brand_name } , <br>${ data.client_name },<br>${ data.client_phone }</td>
          <td>${ data.created_at }</td>
          <td>${ data.fms }</td>
        </tr>
       
      </tbody>
    </table>`);
      $( '#m_modal_orderEditRequest' ).modal( 'show' );
    },
    dataType: "json"
  } );
  //ajax 

}

//changeStatusOnCreditRequest
function changeStatusOnCreditRequest( rowID )
{
  //alert( rowID );
}

//changeStatusOnCreditRequest

//orderEditREQ

function changeStatusSaleJInvoice( rowID )
{
  // alert( rowID );
}

function sfotDeleteOrder( rowid )
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
        url: BASE_URL + "/deleteQcForm",
        type: 'POST',
        data: { _token: $( 'meta[name="csrf-token"]' ).attr( 'content' ), form_id: rowid },
        success: function ( resp )
        {

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
            swal( "Deleted!", "Your Order has been deleted.", "success" ).then( function ( eyz )
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



function filterPurchasebydays( days )
{
  location.reload();
  $( '#txtNumberofdays' ).val( days );
  var myid = '#aj' + days;
  localStorage.mycurrID = myid;



}
function filterPurchasebydaysAll()
{
  location.reload( 1 );

  //alert();
}





function viewOrderDataIMGPurchase( rowid )
{
  var formData = {
    'rowid': rowid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getQCFormOrderData',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      $( '#MyIMGSHOW' ).html( "" );
      var IMGURL = BASE_URL + "/" + res.qc_data.img_url;

      $( '#m_modal_4_showQCFormDataIMG_Purchase' ).modal( 'show' );
      $( '#MyIMGSHOW' ).html( `<img src="${ IMGURL }">` );
    },
    dataType: 'json'

  } );

}


function againDispatchOrder( formID )
{



  $( '#txtOrderID_FORMID1' ).val( formID );
  $( '#txtorderStepID1' ).val( formID );
  $( '#txtProcess_days1' ).val( formID );
  $( '#txtProcess_Name1' ).val( formID );
  $( '#expectedDate1' ).val( '2019-05-20' );


  var formData = {
    'rowid': formID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getPartialOrderQty',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      console.log( res );

      $( '#txtTotalOrderUnit' ).val( res );
      $( '#m_modal_5_orderComment_OrderPartial' ).modal( 'show' );
    },
    dataType: 'json'

  } );


}



//showGeneralViewPurchase
function showGeneralViewPurchase( process_id, ticket_id, dependent_ticket )
{


  //ajax call
  var formData = {
    'form_id': ticket_id,
    'process_id': process_id,
    'dependent_ticket': dependent_ticket,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getAllOrderStagev1',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      //console.log(res.process_data);
      $( '#BOMID' ).val( ticket_id );
      $( '#BOMIDRV' ).val( ticket_id );

      $( '.ajcustomProgessBar' ).html( `` );
      $( '.ajorderTable' ).html( `<tr>
    <th scope="row">Order ID:<b>${ res.process_data.order_id }/${ res.process_data.sub_order_index }</b></th>
    <td>Brand Name:<b>${ res.process_data.order_name }</b></td>
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
    <td></td>
    <td>${ st.completed_by }</td>
  </tr>`;

      } );

      $( '.StageActionHistory' ).html( HistoryHTML );

      var HTML = '';

      $.each( res.stages_info, function ( key, st )
      {
        console.log( st );


        if ( st.started )
        {
          if ( st.started )
          {
            HTML += `<a  style="backdround:red" class="active" href="javascript::void(0)" onclick="StageActionWithDetails(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name } </a>`;

          } else
          {
            HTML += `<a  style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetails(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name }</a>`;

          }
        } else
        {
          if ( st.stage_id == 1 && st.stage_access_status == 1 )
          {
            HTML += `<a  data-toggle="m-tooltip" data-placement="top" title="Default light skin" style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetails(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name }</a>`;

          } else
          {
            HTML += `<a  data-toggle="m-tooltip" data-placement="top" title="Default light skin" style="backdround:red" class="notstarted" href="javascript::void(0)" onclick="StageActionWithDetails(${ st.process_id },${ st.stage_id },${ ticket_id },${ st.stage_access_status },${ st.form_id },${ st.rowCount },${ st.dependent_ticket },${ res.itm_qty })">${ st.stage_name } </a>`;

          }
        }


      } );
      $( '.ajcustomProgessBar' ).append( HTML );

      $( '#m_modal_purchaseView' ).modal( 'show' );


    },
    dataType: 'json'
  } );
  //ajax call


}
//showGeneralViewPurchase









// HRMS
$( '#btnAddEmployee' ).click( function ()
{
  $( '#m_modal_AddEmployee' ).modal( 'show' );
} );
$( '#btnAddEmployeeJobRole' ).click( function ()
{
  $( '#m_modal_AddEmployeeJobRole' ).modal( 'show' );
} );

// HRMS


var DatatablesAdvancedFooterCalllback_1 = {
  init: function ()
  {
    $( "#m_table_1_revenueChart" ).DataTable( {
      responsive: !0,
      pageLength: 5,
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
        $( o.column( 6 ).footer() ).html( "$" + mUtil.numberString( i.toFixed( 2 ) ) + "<br/> ( $" + mUtil.numberString( u.toFixed( 2 ) ) + " total)" )
      }
    } )
  }
};
jQuery( document ).ready( function ()
{
  DatatablesAdvancedFooterCalllback_1.init()
} );


// js calender

// js calender




//HTML table 

//HTML table 