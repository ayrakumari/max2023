
function toasterOptions()
{
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
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

$( '#item_qty_old' ).focusout( function ()
{
  var order_type = $( 'input[name="order_type"]:checked' ).val();
  if ( order_type == 1 )
  {
    var order_value = $( this ).val();
    if ( parseInt( order_value ) <= 999 )
    {
      toasterOptions();
      toastr.error( 'Quantity not less then 1000', 'Order Form' );
      $( this ).val( "" );
      return false;
    }
  }
} );


//LeadSampleAddModelSalesLead
function LeadSampleAddModelSalesLead( QUERY_ID )
{
  $( '#m_modal_1_addSampleConfirm' ).modal( 'show' );
  $( '#btnSampleChooseTypeA' ).click( function ()
  {

    var sampleTypeVal = $( "input[name='sampleTypeVal']:checked" ).val();
    var txtUseriDSampleAdd = $( "input[name='txtUseriDSampleAdd']" ).val();
    // alert(sampleTypeVal);
    if ( sampleTypeVal == 2 || sampleTypeVal == 5 )
    {
      //  var LINKURL=BASE_URL+'/sample/createv1/'+sampleTypeVal;
      // sample_URL_LEAD = BASE_URL + '/stage_sales-leadv1/' + QUERY_ID + '/'+sampleTypeVal+"/"+txtUseriDSampleAdd;
      if ( sampleTypeVal == 2 )
      {
        sample_URL_LEAD = BASE_URL + '/stage_sales-leadv1/' + QUERY_ID + '/' + sampleTypeVal + "/" + txtUseriDSampleAdd;

      }
      if ( sampleTypeVal == 5 )
      {
        sample_URL_LEAD = BASE_URL + '/stage_sales-leadv1Modify/' + QUERY_ID + '/' + sampleTypeVal + "/" + txtUseriDSampleAdd;

      }

    } else
    {
      sample_URL_LEAD = BASE_URL + '/stage_sales-leadv2/' + QUERY_ID + '/' + sampleTypeVal + "/" + txtUseriDSampleAdd;

    }





    window.location.href = sample_URL_LEAD;

  } );

}

//LeadSampleAddModelSalesLead

//add client with modal
$( '#btnAddClient_withModal' ).click( function ()
{
  $( '#m_select2_modal' ).modal( 'show' );
} );
//add client with modal
$( '.ajfileupload' ).hide();
$( '#btnImportSample' ).click( function ()
{
  $( ".ajfileupload" ).slideToggle( 'slow' );
} );

$( '#btnImportCancel' ).click( function ()
{
  $( ".ajfileupload" ).slideToggle( 'slow' );
} );

$( "select.aj_item_catcory" ).change( function ()
{

  var formData = {
    'item_cat': $( this ).children( "option:selected" ).val()
  };
  $.ajax( {
    url: BASE_URL + '/getCatItems',
    type: 'GET',
    data: formData,
    success: function ( res )
    {
      console.log( res );
      $( '#m_select2_5' ).html( res );
    }
  } );


} );
//selectSampleData

$( "select.selectSampleData" ).change( function ()
{
  var formData = {
    'sid': $( this ).children( "option:selected" ).val()
  };
  $.ajax( {
    url: BASE_URL + '/getSampleDetailsBYID',
    type: 'GET',
    data: formData,
    success: function ( res )
    {

      $( '#summernoteA' ).summernote( 'reset' );
      $( '#summernoteA' ).summernote( 'code', res.ship_address );
      $.each( res.data, function ( key, val )
      {
        //alert(key + val);
        if ( val.item_info == "" )
        {
          var itemINfor = ""
        } else
        {
          var itemINfor = val.item_info;
        }
        if ( val.is_formulated == 1 )
        {
          var strFormulated = "YES"
        } else
        {
          var strFormulated = "NO"
        }

        $( '.sampleDetails' ).append( `<tr>
          <th scope="row">
          <div class="m-form__group form-group">
															
																<div class="m-checkbox-list">
																	<label class="m-checkbox m-checkbox--state-primary">
																		<input value=" ${ val.sid }"  name="txtSID[]" checked type="checkbox"> ${ val.sid_partby_code }
																		<span></span>
																	</label>
																</div>
																
															</div>
          </th>
          <td>${ val.item_name }</td>
          <td>${ itemINfor }</td>
          <td>${ strFormulated }</td>
          <td>${ val.created_at }</td>
          <td>@jhon</td>
        </tr>`);
      } );



    },
    dataType: "json"
  } );

} );

//selectSampleData

$( "select.client_name" ).change( function ()
{
  var formData = {
    'cid': $( this ).children( "option:selected" ).val()
  };
  $.ajax( {
    url: BASE_URL + '/api/getClientAddress',
    type: 'GET',
    data: formData,
    success: function ( res )
    {
      $( '#client_address' ).val( res.address );
      $( '#client_location' ).val( res.location );
    },
    dataType: "json"
  } );

} );

//addLeadClaimFORMemberbyManager
function addLeadClaimFORMemberbyManager( rowid )
{
  var myid = "#btnLeadClaimFORMemberbyManager_" + rowid;
  var userid = $( myid ).attr( "data-userid" );

  var LINKURL = BASE_URL + '/get-all-avaible-leads/' + userid;

  window.location.href = LINKURL;


}

//addLeadClaimFORMemberbyManager

//addPaymentFORMemberbyManager
function addPaymentFORMemberbyManager( rowid )
{
  var myid = "#btnAddPaymentFORMemberbyManager_" + rowid;
  var userid = $( myid ).attr( "data-userid" );

  var LINKURL = BASE_URL + '/payment-confirmation-request/' + userid;

  window.location.href = LINKURL;


}

//addPaymentFORMemberbyManager

//addOrderFORMemberbyManager
function addOrderFORMemberbyManager( rowid )
{
  var myid = "#btnAddOrderForMemberbyManager_" + rowid;
  var userid = $( myid ).attr( "data-userid" );

  var LINKURL = BASE_URL + '/qcform/creates-member/' + userid;

  window.location.href = LINKURL;


}
//addOrderFORMemberbyManager

//btnAddSampleForMemberbyManager
function addSampleFORMemberbyManager( rowid )
{
  var myid = "#btnAddSampleForMemberbyManager_" + rowid;
  var userid = $( myid ).attr( "data-userid" );
  $( '#txtUseriDSampleAdd' ).val( userid );
  $( '#m_modal_1_addSampleConfirm' ).modal( 'show' );
  $( '#btnSampleChooseTypeA' ).click( function ()
  {

    var sampleTypeVal = $( "input[name='sampleTypeVal']:checked" ).val();
    var txtUseriDSampleAdd = $( "input[name='txtUseriDSampleAdd']" ).val();

    var LINKURL = BASE_URL + '/sample/createv1/' + sampleTypeVal + "/" + txtUseriDSampleAdd;

    window.location.href = LINKURL;

  } );




}

//btnAddSampleForMemberbyManager

//btnTeamMemberCreate
$( '#btnTeamMemberCreate' ).click( function ()
{

  var data = $( ".select2 option:selected" ).text();
  alert( data );

} );

// btnTeamMemberCreate

//ajax request
var formData = {
  'UUID': $( 'meta[name="UUID"]' ).attr( 'content' ),
  '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

};


$.ajax( {
  url: BASE_URL + '/getTree',
  type: 'POST',
  data: formData,
  success: function ( data )
  {
    //-----------------------
    var chart_config = {
      chart: {
        container: "#botreeLayout",
        animateOnInit: true,
        node: {
          collapsable: true
        },
        animation: {
          nodeAnimation: "easeOutBounce",
          nodeSpeed: 700,
          connectorsAnimation: "bounce",
          connectorsSpeed: 700
        },
        connectors: {
          type: 'step'
        },
        node: {
          HTMLclass: 'nodeExample1'
        }


      },
      nodeStructure: data
    };
    new Treant( chart_config );
    //-------------------------
  },
  dataType: 'json'
} );

//ajax request


$( "select.client_name_qcformSIR" ).change( function ()
{
  var cid = $( this ).children( "option:selected" ).val();


  var poFlag = $( "input[name='txtPartialOrder']:checked" ).val();




  //$('#txtRepeatArea').html('');

  var formData = {
    'cid': $( this ).children( "option:selected" ).val(),
    'poFlag': poFlag,
  };
  $.ajax( {
    url: BASE_URL + '/api/getDispachStageOrderListData',
    type: 'GET',
    data: formData,
    success: function ( res )
    {
      //phone
      $( '#txtMyContactNO' ).val( res.clientData.phone );
      $( '#txtMyGSTNO' ).val( res.clientData.gstno );


      $( '#myOrderListSelect' )
        .find( 'option' )
        .remove()
        .end()
        .append( res.HTML_LIST )
        .val( 'whatever' )
        ;

    },
    dataType: 'json'

  } );

} );




$( "select.client_name_qcform" ).change( function ()
{

  var cid = $( this ).children( "option:selected" ).val();
  var formData = {
    'cid': $( this ).children( "option:selected" ).val()
  };

  $.ajax( {
    url: BASE_URL + '/api/getClientBrandName',
    type: 'GET',
    data: formData,
    success: function ( res )
    {

      if ( res.status == 1 )
      {
        $( '#txtCID' ).val( cid );
        $( '#m_modal_5_gst_addrees_add' ).modal( 'show' );
        $( '.aj_addmore_save' ).hide();
        $( '#txtClientGST' ).val( res.gst );
        $( '#txtClientAddress' ).val( res.address );

      } else
      {
        $( '#client_address' ).val( res.comp );
        $( '.aj_addmore_save' ).show();
      }

    },
    dataType: 'json'
  } );

} );
//save feedback of sample

$( '#btnSaveGSTAddess' ).click( function ()
{

  var cid = $( '#txtCID' ).val();
  var txtClientGST = $( '#txtClientGST' ).val();
  var txtClientAddress = $( '#txtClientAddress' ).val();
  var formData = {
    'cid': cid,
    'txtClientGST': txtClientGST,
    'txtClientAddress': txtClientAddress,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/setClientUpdation',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      swal( {
        title: "",
        text: "Submitted Successfully",
        type: "success",
        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
        onClose: function ( e )
        {
          location.reload();
        }
      } )


    }
  } );


} );

$( '#item_qty' ).focusout( function ()
{
  var itemqty = $( this ).val();
  var sp = $( '#item_selling_price' ).val();
  getOrderValue( sp, itemqty );

} );
$( '#item_selling_price' ).focusout( function ()
{
  var sp = $( this ).val();
  var itemqty = $( '#item_qty' ).val();
  getOrderValue( sp, itemqty );

} );

function getOrderValue( SP, QTY )
{
  $( '#order_value' ).val( SP * QTY );
}
//pricePartision 
$( '#item_size' ).focusout( function ()
{
  getPriceValAll();
} );
$( '#item_RM_Price' ).focusout( function ()
{
  getPriceValAll();
} );
$( '#item_BCJ_Price' ).focusout( function ()
{
  getPriceValAll();
} );
$( '#item_Label_Price' ).focusout( function ()
{
  getPriceValAll();
} );

$( '#item_Material_Price' ).focusout( function ()
{
  getPriceValAll();
} );

$( '#item_LabourConversion_Price' ).focusout( function ()
{
  getPriceValAll();
} );

$( '#item_Margin_Price' ).focusout( function ()
{
  getPriceValAll();
} );



function getPriceValAll()
{

  var item_RM_Price = parseFloat( $( '#item_RM_Price' ).val() );
  var item_size = parseFloat( $( '#item_size' ).val() );

  var item_BCJ_Price = parseFloat( $( '#item_BCJ_Price' ).val() );
  var item_Label_Price = parseFloat( $( '#item_Label_Price' ).val() );
  var item_Material_Price = parseFloat( $( '#item_Material_Price' ).val() );
  var item_LabourConversion_Price = parseFloat( $( '#item_LabourConversion_Price' ).val() );
  var item_Margin_Price = parseFloat( $( '#item_Margin_Price' ).val() );
  var item_qty = parseFloat( $( '#item_qty' ).val() );

  var allPriceAdd = ( ( item_RM_Price * item_size ) / 1000 ) + ( item_BCJ_Price + item_Label_Price + item_Material_Price + item_LabourConversion_Price + item_Margin_Price );

  $( '#item_selling_price' ).val( parseFloat( allPriceAdd ).toFixed( 2 ) );
  $( '#order_value' ).val( parseFloat( allPriceAdd * item_qty ).toFixed( 2 ) );

}
//pricePartision 

//btnSaveSampleAssingnRM
$( '#btnSaveSampleAssingnRM' ).click( function ()
{
  var txtSampleAssinedRemark = $( "#txtSampleAssinedRemarkRM" ).val();
  var sampleIDA = $( "#sampleIDARM" ).val();


  // ajax submit 
  var formData = {

    'sampleIDA': sampleIDA,
    'txtSampleAssinedRemark': txtSampleAssinedRemark,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

  };
  $.ajax( {
    url: BASE_URL + '/saveSampleRejectModify',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      swal( {
        title: "",
        text: "Wait for Auto Assinged Process",
        type: "success",
        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
        onClose: function ( e )
        {
          // location.reload();
          $( '#m_modal_6_sampleRejectModify' ).modal( 'hide' );
        }
      } )

    },
    dataType: 'json'
  } );
  // ajax submit 

} );

//btnSaveSampleAssingnRM

//btnSaveSampleAssingnTrackID
$( '#btnSaveSampleAssingnTrackID' ).click( function ()
{
  var txtSampleAssinedRemark = $( "#txtSampleAssinedRemarkTID" ).val();
  var sampleIDA = $( "#sampleIDATrackID" ).val();

  var txtTrackIDV = $( "#txtTrackIDV" ).val();
  if ( !txtTrackIDV )
  {
    alert( 'Enter Tracking ID' );
    return false;
  }
  // ajax submit 
  var formData = {
    'txtTrackIDV': txtTrackIDV,
    'sampleIDA': sampleIDA,
    'txtSampleAssinedRemark': txtSampleAssinedRemark,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

  };
  $.ajax( {
    url: BASE_URL + '/updateSampleTrackingID',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      
      swal( {
        title: "",
        text: "Tracking ID Updated Successfully",
        type: "success",
        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
        onClose: function ( e )
        {
          // location.reload();
          $( '#m_modal_6_assinedSampleToTID' ).modal( 'hide' );
        }
      } )

    },
    dataType: 'json'
  } );
  // ajax submit 

} );
//btnSaveSampleAssingnTrackID

//btnSaveSampleAssingn
$( '#btnSaveSampleAssingn' ).click( function ()
{
  var txtSampleAssinedRemark = $( "#txtSampleAssinedRemark" ).val();
  var sampleIDA = $( "#sampleIDA" ).val();

  var chemistID = $( "#chemistID option:selected" ).val();
  if ( !chemistID )
  {
    alert( 'Select Option' );
    return false;
  }
  // ajax submit 
  var formData = {
    'chemistID': chemistID,
    'sampleIDA': sampleIDA,
    'txtSampleAssinedRemark': txtSampleAssinedRemark,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

  };
  $.ajax( {
    url: BASE_URL + '/saveSampleAssinged',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      swal( {
        title: "",
        text: "Wait for Auto Assinged Process",
        type: "success",
        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
        onClose: function ( e )
        {
          // location.reload();
          $( '#m_modal_6_assinedSampleTo' ).modal( 'hide' );
        }
      } )

    },
    dataType: 'json'
  } );
  // ajax submit 

} );
//btnSaveSampleAssingn
//btnsaveRemovePaymentDeduct
$( '#btnsaveRemovePaymentDeduct' ).click( function ()
{

  var amountTobeDeduct = $( "#amountTobeDeduct" ).val();
  var in_user_id = $( "#in_user_id" ).val();
  var in_user_month = $( "#in_user_month" ).val();
  var in_user_year = $( "#in_user_year" ).val();
  var ori_order_amt = $( "#ori_order_amt" ).val();

  var feedback_option = $( "#paymentRemovalOptionDeduct option:selected" ).val();


  if ( feedback_option == 0 )
  {
    alert( 'Select Option' );
    return false;
  }
  var feedback_other = $( "textarea#paymentRemovalRemarksDeduct" ).val();
  var formData = {
    'amountTobeDeduct': amountTobeDeduct,
    'in_user_id': in_user_id,
    'in_user_month': in_user_month,
    'in_user_year': in_user_year,
    'ori_order_amt': ori_order_amt,
    'feedback_option': feedback_option,
    'feedback_other': feedback_other,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

  };
  $.ajax( {
    url: BASE_URL + '/savePaymentRemovewithReasonDeduction',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      toasterOptions();
      toastr.success( 'Removed Successfully', 'Payment Removal' );
      location.reload( 1 );
    },
    dataType: 'json'
  } );

} );
//btnsaveRemovePaymentDeduct

//btnsaveRemovePayment

$( '#btnsaveRemovePayment' ).click( function ()
{

  var payIDDone = $( "#payIDDone" ).val();

  var feedback_option = $( "#paymentRemovalOption option:selected" ).val();


  if ( feedback_option == 0 )
  {
    alert( 'Select Option' );
    return false;
  }
  var feedback_other = $( "textarea#paymentRemovalRemarks" ).val();
  var formData = {
    'payIDDone': payIDDone,
    'feedback_option': feedback_option,
    'feedback_other': feedback_other,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

  };
  $.ajax( {
    url: BASE_URL + '/savePaymentRemovewithReason',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      toasterOptions();
      toastr.success( 'Removed Successfully', 'Payment Removal' );
      location.reload( 1 );
    },
    dataType: 'json'
  } );

} );

//btnsavePaymentSample
$( '#btnsaveFeedback' ).click( function ()
{
  
});
//btnsavePaymentSample

//btnsaveRemovePayment

$( '#btnsaveFeedback' ).click( function ()
{
  var s_id = $( "#v_s_id" ).val();

  var feedback_option = $( "#feedback_option1 option:selected" ).val();


  if ( feedback_option == 0 )
  {
    alert( 'Select Option' );
    return false;
  }
  var feedback_other = $( "textarea#txtFeedbackRemarks" ).val();
  var formData = {
    's_id': s_id,
    'feedback_option': feedback_option,
    'feedback_other': feedback_other,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

  };
  $.ajax( {
    url: BASE_URL + '/saveFeedback',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      swal( {
        title: "",
        text: "Feedback Added Successfully",
        type: "success",
        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
        onClose: function ( e )
        {
          location.reload();
        }
      } )

    },
    dataType: 'json'
  } );

} );

//alert(s_id+feedback_option+feedback_other);

$( '.ajorderhiderate' ).hide();
$( "select.currency_order" ).change( function ()
{

  var selectedCountry = $( this ).children( "option:selected" ).val();



  if ( selectedCountry == 'INR' )
  {
    $( '.ajorderhiderate' ).hide();
  } else
  {
    $( '.ajorderhiderate' ).show( 'fast' );
    $( '.ajorderhiderate' ).focus();
  }

} );


$( "input[name='currency']" ).change( function ()
{

  //alert(55);

  var radioValue = $( "input[name='currency']:option:selected" ).val();



} );

$( "input[name='order_repeat']" ).click( function ()
{

  var radioValue = $( "input[name='order_repeat']:checked" ).val();

  if ( radioValue == 1 )
  {
    $( '.ajorderhide' ).hide();
  } else
  {
    $( '.ajorderhide' ).show( 'fast' );
  }

} );
//$("input[name='order_type']").prop("checked", false);


var oType = $( '#editOrderNewWay' ).val();

if ( oType == 'Bulk' )
{
  $( '.bulkOrderArea' ).css( 'display', 'block' );
  $( '.PrivateOrder' ).css( 'display', 'none' );
} else
{
  $( '.bulkOrderArea' ).css( 'display', 'none' );
  $( '.PrivateOrder' ).css( 'display', 'block' );
}
//=================================================
$( "input[name='order_type']" ).click( function ()
{
  var radioValue = $( "input[name='order_type']:checked" ).val();
  if ( radioValue == 2 )
  {
    //bulk order
    //alert('Order Order ');
    $( '#txtOrderTypeNew' ).val( 2 );

    $( ".item_size_unitBULK option" ).remove();
    $( ".item_size_unitBULK" ).append( '<option value="L">L</option>' );
    $( ".item_size_unitBULK" ).append( '<option value="Kg">Kg</option>' );
    $( ".item_size_unitBULK" ).append( '<option value="PCS">PCS</option>' );


    $( '.bulkOrderArea' ).css( 'display', 'block' );
    $( '.PrivateOrder' ).css( 'display', 'none' );

  } else
  {
    //private Label
    $( '#txtOrderTypeNew' ).val( 1 );
    $( '.bulkOrderArea' ).css( 'display', 'none' );
    $( '.PrivateOrder' ).css( 'display', 'block' );

    //--------------------
    $( '.ajorderType' ).show( 'fast' );
    $( "#item_size_unit option" ).remove();
    $( "#item_qty_unit option" ).remove();
    $( "#item_selling_UNIT option" ).remove();


    $( "#item_size_unit" ).append( '<option value="Ml">ml</option>' );

    $( "#item_size_unit" ).append( '<option value="gm">gm</option>' );
    $( "#item_qty_unit" ).append( '<option value="pcs">pcs</option>' );

    $( "#item_selling_UNIT" ).append( '<option value="pcs">pcs</option>' );

    //-------------------

  }

} );
//===============================================
$( "input[name='order_typeOLD']" ).click( function ()
{

  var radioValue = $( "input[name='order_type']:checked" ).val();

  if ( radioValue == 2 )
  {
    $( '.ajorderType' ).hide();
    //code for size
    $( '#txtOrderTypeNew' ).val( 2 );
    $( "#item_size_unit option" ).remove();
    $( "#item_qty_unit option" ).remove();
    $( "#item_selling_UNIT option" ).remove();


    $( "#item_size_unit" ).append( '<option value="L">L</option>' );
    $( "#item_size_unit" ).append( '<option value="Kg">Kg</option>' );


    $( "#item_qty_unit" ).append( '<option value="L">L</option>' );
    $( "#item_qty_unit" ).append( '<option value="Kg">Kg</option>' );


    $( "#item_selling_UNIT" ).append( '<option value="L">L</option>' );
    $( "#item_selling_UNIT" ).append( '<option value="Kg">Kg</option>' );







    //code for size

  } else
  {
    $( '#txtOrderTypeNew' ).val( 1 );

    $( '.ajorderType' ).show( 'fast' );
    $( "#item_size_unit option" ).remove();
    $( "#item_qty_unit option" ).remove();
    $( "#item_selling_UNIT option" ).remove();


    $( "#item_size_unit" ).append( '<option value="Ml">ml</option>' );

    $( "#item_size_unit" ).append( '<option value="gm">gm</option>' );
    $( "#item_qty_unit" ).append( '<option value="pcs">pcs</option>' );

    $( "#item_selling_UNIT" ).append( '<option value="pcs">pcs</option>' );



  }


} );

//btnSaveSampleSetPriority
$( '#btnSaveSampleSetPriority' ).click( function ()
{
  var txtSampleAssinedRemark = $( "#txtSampleAssinedRemark_priority" ).val();
  var sampleIDA = $( "#sampleIDAP" ).val();

  var chemistID = $( "#sample_flag_priority option:selected" ).val();
  if ( !chemistID )
  {
    alert( 'Select Option' );
    return false;
  }
  // ajax submit 
  var formData = {
    'flag_id': chemistID,
    'sampleIDA': sampleIDA,
    'txtSampleAssinedRemark': txtSampleAssinedRemark,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

  };
  $.ajax( {
    url: BASE_URL + '/saveSamplePriority',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      toasterOptions();
      toastr.success( 'Successfully Submitted ', 'Sample Priority' );
      //return false;
      setTimeout( function ()
      {
        $( '#m_modal_6_assinedSampleTo89' ).modal( 'hide' );


      }, 500 );



    },
    dataType: 'json'
  } );
  // ajax submit 

} );
//btnSaveSampleSetPriority

$( '#btnSaveSampleSent' ).click( function ()
{
  var courier_details = $( "#courier_data option:selected" ).val();
  var status_sample = $( "#status_sample option:selected" ).val();

  var track_id = $( "#track_id" ).val();
  var s_id = $( "#v_s_id" ).val();
  var remarks = $( "textarea#txtRemarksArea" ).val();
  var sent_date = $( "#m_datepicker_3" ).val();
  if ( courier_details == "" || courier_details == 'NULL' )
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
    'sample_status': status_sample,
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

//btnPrintSampleXL
$( '#btnPrintSampleXL_P' ).click( function ()
{
 
  alert(555);

  var divToPrintA = document.getElementById( 'div_printmeXL_P' );

  var newWinA = window.open( '', 'Print-Window' );

  newWinA.document.open();

  newWinA.document.write( '<html><body onload="window.print()">' + divToPrintA.innerHTML + '</body></html>' );

  newWinA.document.close();

  setTimeout( function () { newWinA.close(); }, 10 );
} );

//btnPrintSampleXL


//btnPrintSampleRNDFormula
$( '#btnPrintSampleRNDFormula' ).click( function ()
{

  var divToPrintA = document.getElementById( 'div_printmeRND' );

  var newWinA = window.open( '', 'Print-Window' );

  newWinA.document.open();

  newWinA.document.write( '<html><body onload="window.print()">' + divToPrintA.innerHTML + '</body></html>' );

  newWinA.document.close();

  setTimeout( function () { newWinA.close(); }, 10 );
} );
//btnPrintSampleRNDFormula

//btnPrintSampleV2
$( '#btnPrintSampleX' ).click( function ()
{

  var divToPrintA = document.getElementById( 'div_printmeX' );

  var newWinA = window.open( '', 'Print-Window' );

  newWinA.document.open();

  newWinA.document.write( '<html><body onload="window.print()">' + divToPrintA.innerHTML + '</body></html>' );

  newWinA.document.close();

  setTimeout( function () { newWinA.close(); }, 10 );
} );
//btnPrintSampleV2
 

//print samples
$( '#btnPrintSample' ).click( function ()
{
  var divToPrint = document.getElementById( 'div_printme' );

  var newWin = window.open( '', 'Print-Window' );

  newWin.document.open();

  newWin.document.write( '<html><body onload="window.print()">' + div_printme.innerHTML + '</body></html>' );

  newWin.document.close();

  setTimeout( function () { newWin.close(); }, 10 );
} );
//
$( '#btnPrintPlanList' ).click( function ()
{
  var divToPrint = document.getElementById( 'div_printme' );

  var newWin = window.open( '', 'Print-Window' );

  newWin.document.open();

  newWin.document.write( '<html><body onload="window.print()">' + div_printme.innerHTML + '</body></html>' );

  newWin.document.close();

  setTimeout( function () { newWin.close(); }, 10 );
} );


//btnCatSubmit:this function is used to save category to db
$( '#btnCatSubmit' ).click( function ()
{
  var formData = {
    'category': $( '#txtCat' ).val(),
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

  };
  // ajax call
  $.ajax( {
    url: BASE_URL + '/saveCateory',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '#m_select2_4' ).html( res );
      $( '#m_select2_2_modal' ).html( res );

      $( '#m_select2_modal_2' ).modal( 'hide' );
    }

  } );


} );

$( '#btnCatSubmitStock' ).click( function ()
{
  var formData = {
    'category': $( '#txtCat' ).val(),
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

  };
  // ajax call
  $.ajax( {
    url: BASE_URL + '/saveCateory',
    type: 'POST',
    data: formData,
    success: function ( res )
    {


      swal( {
        title: "Category Added Successfully",
        text: "",
        type: "success",
        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
        onClose: function ( e )
        {
          console.log( "on close event fired!" )
        }
      } )
      $( '#txtCat' ).val( " " )


    }

  } );


} );
//btnCatSubmit:this function is used to save category to db

// btnAddItemSubmit
$( '#btnAddItemSubmit' ).click( function ()
{

  var item_cat = $( "#m_select2_2_modal option:selected" ).val();
  var item_cat_name = $( "#txtAddCat" ).val();
  //  ajax call
  var formData = {
    'cat_id': item_cat,
    'item_name': item_cat_name,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/saveItemName',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      console.log( res );

      $( '#m_select2_modal' ).modal( 'hide' );
    }

  } );

  //  ajax call

} );


$( '#btnAddItemSubmitStock' ).click( function ()
{

  var item_cat = $( "#m_select2_2_modal_stock option:selected" ).val();
  var item_cat_name = $( "#txtAddCat" ).val();
  //  ajax call
  var formData = {
    'cat_id': item_cat,
    'item_name': item_cat_name,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/saveItemName',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      console.log( res );

      $( '#m_select2_modal' ).modal( 'hide' );
    }

  } );

  //  ajax call

} );


// btnAddItemSubmit

//pid_event // this is used to enter purchase order id on keychanfe show data to

// $('#pid_event').live('keypress', function (e) {
//   if ( e.which == 9 )
//       alert( 'Tab pressed' );
// });

$( '#pid_event' ).keypress( function ( event )
{
  var keycode = ( event.keyCode ? event.keyCode : event.which );
  if ( keycode == '13' )
  {
    var dInput = this.value;
    //  ajax call
    var formData = {
      'pid': dInput,
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ) //need to find data and show and save entry to recifed and issue is to make
    };
    $.ajax( {
      url: BASE_URL + '/getPurchaseOrderData',
      type: 'POST',
      data: formData,
      success: function ( res )
      {

        if ( res.status )
        {
          console.log( res.data.ven_id );

          $( '.vendorLists  option[value="' + res.data.ven_id + '"]' ).prop( "selected", true );
          $( '#item_code' ).val( res.data.item_code );
          $( '#item_name' ).val( res.data.item_name );
          $( '#qty' ).val( res.data.item_qty );
          $( '#rec_qty' ).focus();


        } else
        {
          $( '.vendorLists  option[value="' + res.data.ven_id + '"]' ).prop( "selected", false );
          $( '#item_code' ).val( '' );
          $( '#item_name' ).val( '' );
          $( '#qty' ).val( '' );

          swal( {
            title: "Invalid PID",
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
      }

    } );

    //  ajax call
  }



} );


//btnSavePurchaseOrder :this function is used to saved received order data
$( '#btnSavePurchaseOrder' ).click( function ()
{
  var rec_qty = $( '#rec_qty' ).val();

  if ( rec_qty == "" )
  {
    swal( {
      title: "Enter Recieved Quantity",
      text: "",
      type: "error",
      confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
      onClose: function ( e )
      {
        console.log( "on close event fired!" );

      }
    } )
    $( '#rec_qty' ).focus();
    return false;

  }


  var formData = {
    'pid': $( '#pid_event' ).val(),
    'rec_qty': $( '#rec_qty' ).val(),
    'invoice_no': $( '#invoice_no' ).val(),
    'rec_remarks': $( 'textarea#rec_remarks ' ).val(),
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ) //need to find data and show and save entry to recifed and issue is to make
  };
  $.ajax( {
    url: BASE_URL + '/saveRecievedPurchaseOrder',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      console.log( res );

      window.location.href = BASE_URL + "/recieved-orders"
    }
  } );

} );
//btnSavePurchaseOrder : this function is used to saved received order data

//btnSaveStockEntry
$( '#btnSaveStockEntry' ).click( function ()
{




  //  ajax call
  var formData = {
    'catName': $( '.catName' ).val(),
    'itemName': $( '#itemName' ).val(),
    'shortName': $( '#shortName' ).val(),
    'unitName': $( '#unitName' ).val(),
    'stock_qty': $( '#stock_qty' ).val(),
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ) //need to find data and show and save entry to recifed and issue is to make
  };
  $.ajax( {
    url: BASE_URL + '/saveStockItems',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      console.log( res );
      location.reload();

    }
  } );

  //  ajax call


} );

//SelectPrintChemistSample
$( '#SelectPrintChemistSample' ).change( function ()
{

  var sampleTypeVal = $( "#SelectPrintChemistSample option:selected" ).val();

  //  var LINKURL=BASE_URL+'/sample/createv1/'+sampleTypeVal;
  sample_URL_LEAD = BASE_URL + '/viewSampleAssinedListMe/' + sampleTypeVal;
  //sample_URL_LEAD = BASE_URL + '/sample-assinged-list';
  window.location.href = sample_URL_LEAD;

} );

//SelectPrintChemistSample
//btnViewSampleStandardList
$( '#btnViewSampleStandardList' ).click( function ()
{

  var sampleTypeVal = $( "input[name='samplePrintCat']:checked" ).val();

  //  var LINKURL=BASE_URL+'/sample/createv1/'+sampleTypeVal;
  //sample_URL_LEAD = BASE_URL + '/sample-assinged-list/'+sampleTypeVal;
  sample_URL_LEAD = BASE_URL + '/sample-standard-list';
  window.location.href = sample_URL_LEAD;

} );

//btnViewSampleStandardList

//btnViewSampleBenchmarkList

$( '#btnViewSampleBenchmarkList' ).click( function ()
{

  var sampleTypeVal = $( "input[name='samplePrintCat']:checked" ).val();

  //  var LINKURL=BASE_URL+'/sample/createv1/'+sampleTypeVal;
  //sample_URL_LEAD = BASE_URL + '/sample-assinged-list/'+sampleTypeVal;
  sample_URL_LEAD = BASE_URL + '/sample-benchmark-list';
  window.location.href = sample_URL_LEAD;

} );

//btnViewSampleBenchmarkList



//btnViewSampleAssingedList
$( '#btnViewSampleAssingedList' ).click( function ()
{

  var sampleTypeVal = $( "input[name='samplePrintCat']:checked" ).val();

  //  var LINKURL=BASE_URL+'/sample/createv1/'+sampleTypeVal;
  //sample_URL_LEAD = BASE_URL + '/sample-assinged-list/'+sampleTypeVal;
  sample_URL_LEAD = BASE_URL + '/sample-assinged-list';
  window.location.href = sample_URL_LEAD;

} );

//btnViewSampleAssingedList
//btnViewSamplePendingList


$( '#btnViewSamplePendingList' ).click( function ()
{

  var sampleTypeVal = $( "input[name='samplePrintCat']:checked" ).val();

  //  var LINKURL=BASE_URL+'/sample/createv1/'+sampleTypeVal;
  sample_URL_LEAD = BASE_URL + '/sample-pending-list/' + sampleTypeVal;
  window.location.href = sample_URL_LEAD;

} );



//btnViewSamplePendingList

//btnSaveStockEntry
function LeadSampleAddModelSales( QUERY_ID )
{
  $( '#m_modal_1_addSampleConfirm' ).modal( 'show' );
  $( '#btnSampleChooseTypeA' ).click( function ()
  {

    var sampleTypeVal = $( "input[name='sampleTypeVal']:checked" ).val();
    var txtUseriDSampleAdd = $( "input[name='txtUseriDSampleAdd']" ).val();
    //  var LINKURL=BASE_URL+'/sample/createv1/'+sampleTypeVal;
    sample_URL_LEAD = BASE_URL + '/add_stage_sampleV2/' + QUERY_ID + '/' + sampleTypeVal + "/" + txtUseriDSampleAdd;



    window.location.href = sample_URL_LEAD;

  } );

}
//btnAddSampleV1
$( '#btnAddSampleV1' ).click( function ()
{
  $( '#m_modal_1_addSampleConfirm' ).modal( 'show' );
  $( '#btnSampleChooseTypeA' ).click( function ()
  {

    var sampleTypeVal = $( "input[name='sampleTypeVal']:checked" ).val();
    var txtUseriDSampleAdd = $( "input[name='txtUseriDSampleAdd']" ).val();

    var LINKURL = BASE_URL + '/sample/createv1/' + sampleTypeVal + "/" + txtUseriDSampleAdd;

    window.location.href = LINKURL;

  } );

} );
//btnAddSampleV1




$( '#btnAddCategory' ).click( function ()
{
  $( '#m_select2_modal_2' ).modal( 'show' );
} );

$( '#btnCatSubmitStockEntry' ).click( function ()
{
  var formData = {
    'category': $( '#txtCat' ).val(),
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

  };
  // ajax call
  $.ajax( {
    url: BASE_URL + '/saveCateory',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '#m_select2_1' ).html( res );

      $( '#m_select2_modal_2' ).modal( 'hide' );
    }

  } );


} );



//btnUserAccessRight
$( '#btnUserAccessRight' ).click( function ()
{

  var formData = {
    'catsalesUser': $( '#catsalesUser' ).val(),
    'client_id': $( '#client_id' ).val(),
    'exp_date_range': $( '#exp_date_range' ).val(),
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

  };
  $.ajax( {
    url: BASE_URL + '/userAccess',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      swal( {
        title: "Given  Access successfully",
        text: "",
        type: "success",
        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
        onClose: function ( e )
        {
          location.reload();
        }
      } )

    }

  } );


} );
//btnUserAccessRight

function deleteUserAccess( rowid )
{

  var formData = {
    'rowid': rowid,

    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

  };
  $.ajax( {
    url: BASE_URL + '/userAccessRemove',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      console.log( res );

      swal( {
        title: "Removed  Access successfully",
        text: "",
        type: "success",
        confirmButtonClass: "btn btn-secondary m-btn m-btn--wide",
        onClose: function ( e )
        {
          location.reload();
        }
      } )

    }

  } );


}


//add more order item

$( '#btnAddMoreOrderItem' ).click( function ()
{
  $( '#m_modal_4_addmoreorder' ).modal( 'show' );
} );

//save oder items
$( '#btnSaveOrderItem' ).click( function ()
{
  //ajax call
  var formData = {
    'txtOrderID': $( '#txtOrderId' ).val(),
    'txtItemName': $( '#txtItemName' ).val(),
    'txtItemQTY': $( '#txtItemQTY' ).val(),
    'txtSize': $( '#txtSize' ).val(),
    'txtSampleId': $( '#txtSampleId' ).val(),

    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/saveOrderItemsAddmore',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      location.reload( 1 );

    }

  } );


  //ajax call

} )

$( '.ajshdate' ).hide();
$( "#txtchk" ).prop( "checked", true );
$( '.txtsch' ).click( function ()
{

  var txtsch = $( this ).val();

  if ( txtsch == 1 )
  {

    $( '.ajshdate' ).show();
  }
  if ( txtsch == 2 )
  {

    $( '.ajshdate' ).hide();
  }

} );


$( '.ajfeedback' ).hide();
$( "#txtfeedback" ).prop( "checked", true );

$( '.txtfeedback' ).click( function ()
{

  var txtfeedback = $( this ).val();

  if ( txtfeedback == 1 )
  {

    $( '.ajfeedback' ).show();
  }
  if ( txtfeedback == 2 )
  {

    $( '.ajfeedback' ).hide();
  }

} );

//aj_date_dropdown
var default_date = moment().add( 3, 'days' ).format( 'YYYY-MM-DD' );
var default_date_p = moment().subtract( 1, 'days' ).format( 'YYYY-MM-DD' );

$( '#shdate_input' ).val( default_date );

$( '#print_sample_date' ).val( default_date_p );
$( '#print_sample_datev2' ).val( default_date_p );


$( '#aj_yesterday,#aj_yesterday_v2' ).click( function ()
{

  var aj_yestarday = moment().subtract( 1, 'days' ).format( 'YYYY-MM-DD' );
  $( '#print_sample_date' ).val( aj_yestarday );
  $( '#print_sample_datev2' ).val( aj_yestarday );
} );

$( '#aj_today,#aj_today1,#aj_today1_v2' ).click( function ()
{
  var aj_today = moment().format( 'YYYY-MM-DD' );
  $( '#shdate_input' ).val( aj_today );
  $( '#print_sample_date' ).val( aj_today );
  $( '#print_sample_datev2' ).val( aj_today );
} );
$( '#aj_3days' ).click( function ()
{
  var aj_3days = moment().add( 3, 'days' ).format( 'YYYY-MM-DD' );

  $( '#shdate_input' ).val( aj_3days );
  $( '#print_sample_date' ).val( aj_3days );

} );
$( '#aj_7days,#aj_7days1,#aj_7days1_v2' ).click( function ()
{
  var aj_7days = moment().add( 7, 'days' ).format( 'YYYY-MM-DD' );
  var aj_7days_print = moment().subtract( 7, 'days' ).format( 'YYYY-MM-DD' );
  $( '#shdate_input' ).val( aj_7days );
  $( '#print_sample_date' ).val( aj_7days_print );
  $( '#print_sample_datev2' ).val( aj_7days_print );

} );
var aj_todayTodays = moment().add( 0, 'days' ).format( 'YYYY-MM-DD' );
$("input[name=print_sample_date_to]").val(aj_todayTodays);

$( '#aj_15days,#aj_15days1,#aj_15days1_v2' ).click( function ()
{
  var aj_15days = moment().add( 15, 'days' ).format( 'YYYY-MM-DD' );
  var aj_15days_print = moment().subtract( 15, 'days' ).format( 'YYYY-MM-DD' );
  $( '#shdate_input' ).val( aj_15days );
  $( '#print_sample_date' ).val( aj_15days_print );
  $( '#print_sample_datev2' ).val( aj_15days_print );

} );


$( '#aj_next_month,#aj_next_month1,#aj_next_month1_v2' ).click( function ()
{
  var aj_next_month = moment().add( 30, 'days' ).format( 'YYYY-MM-DD' );
  var aj_nextmonth_print = moment().subtract( 30, 'days' ).format( 'YYYY-MM-DD' );
  $( '#shdate_input' ).val( aj_next_month );
  $( '#print_sample_date' ).val( aj_nextmonth_print );
  $( '#print_sample_datev2' ).val( aj_nextmonth_print );
} );
//aj_date_dropdown

// sample v2 date calender 




// sample v2 date calender 

//btnPasswordReset
$( '#btnPasswordReset' ).click( function ()
{
  var curr_pass = $( '#current' ).val();
  var new_pass = $( '#password' ).val();
  var confirm_pass = $( '#confirmed' ).val();
  if ( curr_pass == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Current Password', 'Password Reset' );
    return false;
  }
  if ( new_pass == "" )
  {
    toasterOptions();
    toastr.error( 'Enter New Password', 'Password Reset' );
    return false;
  }
  if ( confirm_pass == "" )
  {
    toasterOptions();
    toastr.error( 'Enter Confirm Password', 'Password Reset' );
    return false;
  }
  if ( confirm_pass != new_pass )
  {
    toasterOptions();
    toastr.error( 'Password Mismatched', 'Password Reset' );
    return false;
  }
  var formData = {
    'current': curr_pass,
    'password': new_pass,
    'confirmed': confirm_pass,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
    'user_id': $( 'meta[name="UUID"]' ).attr( 'content' ),

  };
  $.ajax( {
    url: BASE_URL + '/UserResetPassword',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toasterOptions();
        toastr.success( 'Password successfully changed', 'Password Reset' );
      }
      if ( res.status == 2 )
      {
        toasterOptions();
        toastr.error( 'Your current password does not matches with the password you provided', 'Password Reset' );
      }
      if ( res.status == 3 )
      {
        toasterOptions();
        toastr.error( 'New Password cannot be same as your current password. Please choose a different password..', 'Password Reset' );
      }

    }

  } );




} );
//btnPasswordReset

$( '.ajorderhide' ).hide();
$( '.aj_addmore' ).hide();
$( '.ajitemTable' ).hide();

$( '#formLayoutAJ' ).show();
$( '.aj_addmore' ).click( function ()
{

  $( '#item_name' ).val( "" );
  $( '#item_size' ).val( "" );
  $( '#item_qty' ).val( "" );
  $( '#item_fm_sample_no_bulk_N' ).val( "" );
  $( '#item_fm_sample_bulk_N' ).val( "" );
  $( '#item_selling_price' ).val( "" );

  $( '#formLayoutAJ' ).show();
  $( '.aj_addmore_save' ).show();
  $( this ).hide();

} );

//item_fm_sample_no
$( "select.item_fm_sample_no" ).change( function ()
{
  var sample_code = $( this ).children( "option:selected" ).val();
  // alert(sample_code);
  $('#item_fm_sample_no_bulkX').val(sample_code);
  $('#lblItemS').html(sample_code);

});
//item_fm_sample_no


// showOrderItemTechDataSelect
$( "select.showOrderItemTechDataSelect" ).change( function ()
{
  var form_ID = $( this ).children( "option:selected" ).val();

  // ajax
  var formData = {
    'form_ID': form_ID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),

  };
  $.ajax( {
    url: BASE_URL + '/getOrderItemsDataTech',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '.showOrderItemTechData' ).html( '' );
      $( '#btnOrderTechSubmit' ).removeAttr( "disabled" );
      $.each( res.data, function ( index, value )
      {
        // console.log(value.item_name);
        $( '.showOrderItemTechData' ).append( `<div class="m-checkbox-list">
        <label class="m-checkbox m-checkbox--square">
          <input type="checkbox" name="order_by_part_id[]" value="${ value.item_name }-@@-${ value.id }-XX-${ value.order_type }"> ${ value.item_name }
          
          <span></span>
        </label>
      </div>`);
      } );


    },
    dataType: "json"
  } );
  // ajax

} );

//showSampleItemTechDataSelect
$( "select.showSampleItemTechDataSelect" ).change( function ()
{
  var SID = $( this ).children( "option:selected" ).val();
  $( '.showSampleItemTechData' ).html( "" );

  if ( SID == 9999999 )
  {

    $( '.showSampleItemTechData' ).append( `<div class="m-checbox-list">
    <label class="">
      <input type="text" class="form-control" name="sample_by_part_id">       
      <span></span>
    </label>
  </div>`);
    $( '#btnSampleTechSubmit' ).removeAttr( "disabled" );

  } else
  {

    //  ajax //
    var formData = {
      'SID': SID,
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),

    };
    $.ajax( {
      url: BASE_URL + '/getSampleItemsDataTech',
      type: 'POST',
      data: formData,
      success: function ( res )
      {
        // console.log(res);
        $( '.showSampleItemTechData' ).html( '' );
        $( '#btnSampleTechSubmit' ).removeAttr( "disabled" );
        $.each( res.data, function ( index, value )
        {
          $( '.showSampleItemTechData' ).append( `<div class="m-checkbox-list">
        <label class="m-checkbox m-checkbox--square">
          <input type="checkbox" name="sample_by_part_id[]" value="${ value.sample_id }@@${ value.sample_itemname }"> ${ value.sample_itemname }         
          <span></span>
        </label>
      </div>`);
        } );



      }
    } );
    // ajax //
  }

} );
//showSampleItemTechDataSelect
//orderSampleIDViewSampleModi
$( "select.orderSampleIDViewSampleModi" ).change( function ()
{
  var SID = $( this ).children( "option:selected" ).val();
  //ajax
  var formData = {
    'SID': SID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),

  };
  $.ajax( {
    url: BASE_URL + '/getSampleFormulatDetailsViewSampleModi',
    type: 'GET',
    data: formData,
    success: function ( res )
    {
      console.log( res );
      if ( res.status == 2 )
      {
        $( '.viewitemSelect' ).html( '' );
        //$('.viewitemSelect').html(`<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded"></span>`);

      } else
      {
        var HTML = `<label style="color:#000">Item Name:</label>
        <div class="input-group m-input-group m-input-group--square">
            <select class="form-control" id="txtSample_Name" name="txtSample_Name">
                <option value="">-SELECT-</option>`;
        if ( res[ 0 ].dashCount == 2 )
        {
          $( '.itemNameSample' ).html( `<label style="color:#035496">Item Name:</label>
                  <div class="input-group m-input-group m-input-group--square">
                      <input value="${ res[ 0 ].item_name }" type="text" id="txtSample_Name" name="txtSample_Name" class="form-control m-input" placeholder="">
                  </div>
                  <span class="m-form__help"></span>`);

        } else
        {
          $.each( res, function ( key, val )
          {
            HTML += `<option value="${ val.item_name }">${ val.item_name }</option>`;

          } );
          HTML += `  </select>
                  </div>`;
          $( '.itemNameSample' ).html( HTML );

        }



        $( '.viewitemSelect' ).html( '' );
        $( '.viewitemSelect' ).html( `<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Sample Item Name: :${ res[ 0 ].item_name }</span>` );
      }


    },
    dataType: "json"
  } );
  //ajax
} );

//orderSampleIDViewSampleModi


//orderSampleIDViewSample
$( "select.orderSampleIDViewSample" ).change( function ()
{
  var SID = $( this ).children( "option:selected" ).val();
  //ajax
  var formData = {
    'SID': SID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),

  };
  $.ajax( {
    url: BASE_URL + '/getSampleFormulatDetailsViewSample',
    type: 'GET',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 2 )
      {
        $( '.viewitemSelect' ).html( '' );
        //$('.viewitemSelect').html(`<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded"></span>`);

      } else
      {
        $( '.viewitemSelect' ).html( '' );
        $( '.viewitemSelect' ).html( `<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Sample Item Name: :${ res[ 0 ].item_name }</span>` );
      }


    },
    dataType: "json"
  } );
  //ajax
} );

//orderSampleIDViewSample


$( "select.orderSampleIDView" ).change( function ()
{
  var SID = $( this ).children( "option:selected" ).val();
  //ajax
  var formData = {
    'SID': SID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),

  };
  $.ajax( {
    url: BASE_URL + '/getSampleFormulatDetailsView',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 2 )
      {
        $( '.viewitemSelect' ).html( '' );
        //$('.viewitemSelect').html(`<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded"></span>`);

      } else
      {
        $( '.viewitemSelect' ).html( '' );
        $( '.viewitemSelect' ).html( `<span class="m-badge m-badge--warning m-badge--wide m-badge--rounded">Sample Item Name: :${ res[ 0 ].item_name }</span>` );
      }


    },
    dataType: "json"
  } );
  //ajax
} );

function getOrderItemList( orderid )
{
  var formData = {
    'orderid': orderid,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),

  };
  $.ajax( {
    url: BASE_URL + '/getOrderDataInfo',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '#showitemLayout' ).html( "" );

      $.each( res, function ( index, value )
      {

        $( '#showitemLayout' ).append( `<tr>
        <th>${ value.order_id }/${ value.subOrder }</th>
        <th>${ value.item_name }</th>
        <th>${ value.item_size }</th>
        <th>${ value.item_qty }</th>
        <th>${ value.item_fm_sample_no }</th>
     </tr>`);

        // Will stop running after "three"

      } );


    }

  } );

}

$( '#btnNewOrder' ).click( function ()
{
  location.reload( 1 );
} );



//save wizard
$( '#btnSaveStep_3' ).click( function ()
{

  var step_days_1 = $( "input[name=step_3_days]" ).val();
  var step = $( "input[name=step_3]" ).val();
  var step_remarks_1 = $( "input[name=step_3_remarks]" ).val();
  orderProcessDays( step, step_days_1, step_remarks_1 );
} );

$( '#btnSaveStep_4' ).click( function ()
{

  var step_days_1 = $( "input[name=step_4_days]" ).val();
  var step = $( "input[name=step_4]" ).val();
  var step_remarks_1 = $( "input[name=step_4_remarks]" ).val();
  orderProcessDays( step, step_days_1, step_remarks_1 );
} );

$( '#btnSaveStep_5' ).click( function ()
{
  var step_days_1 = $( "input[name=step_5_days]" ).val();
  var step = $( "input[name=step_5]" ).val();
  var step_remarks_1 = $( "input[name=step_5_remarks]" ).val();
  orderProcessDays( step, step_days_1, step_remarks_1 );

} );

$( '#btnSaveStep_6' ).click( function ()
{
  var step_days_1 = $( "input[name=step_6_days]" ).val();
  var step = $( "input[name=step_6]" ).val();
  var step_remarks_1 = $( "input[name=step_6_remarks]" ).val();
  orderProcessDays( step, step_days_1, step_remarks_1 );

} );

$( '#btnSaveStep_7' ).click( function ()
{
  var step_days_1 = $( "input[name=step_7_days]" ).val();
  var step = $( "input[name=step_7]" ).val();
  var step_remarks_1 = $( "input[name=step_7_remarks]" ).val();
  orderProcessDays( step, step_days_1, step_remarks_1 );

} );

$( '#btnSaveStep_8' ).click( function ()
{
  var step_days_1 = $( "input[name=step_8_days]" ).val();
  var step = $( "input[name=step_8]" ).val();
  var step_remarks_1 = $( "input[name=step_8_remarks]" ).val();
  orderProcessDays( step, step_days_1, step_remarks_1 );

} );


$( '#btnSaveStep_9' ).click( function ()
{
  var step_days_1 = $( "input[name=step_9_days]" ).val();
  var step = $( "input[name=step_9]" ).val();
  var step_remarks_1 = $( "input[name=step_9_remarks]" ).val();
  orderProcessDays( step, step_days_1, step_remarks_1 );

} );

$( '#btnSaveStep_10' ).click( function ()
{
  var step_days_1 = $( "input[name=step_10_days]" ).val();
  var step = $( "input[name=step_10]" ).val();
  var step_remarks_1 = $( "input[name=step_10_remarks]" ).val();
  orderProcessDays( step, step_days_1, step_remarks_1 );

} );


$( '#btnSaveStep_11' ).click( function ()
{
  var step_days_1 = $( "input[name=step_11_days]" ).val();
  var step = $( "input[name=step_11]" ).val();
  var step_remarks_1 = $( "input[name=step_11_remarks]" ).val();
  orderProcessDays( step, step_days_1, step_remarks_1 );

} );

$( '#btnSaveStep_12' ).click( function ()
{

  var step_days_1 = $( "input[name=step_12_days]" ).val();
  var step = $( "input[name=step_12]" ).val();
  var step_remarks_1 = $( "input[name=step_12_remarks]" ).val();
  orderProcessDays( step, step_days_1, step_remarks_1 );

} );



//save wizard

function orderProcessDays( step, step_days, step_remark )
{
  var order_id_form_id = $( '#form_order_id' ).val();
  var formData = {
    ' form_id': order_id_form_id,
    ' step': step,
    ' step_days': step_days,
    ' step_remark': step_remark,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  console.log( formData );
  $.ajax( {
    url: BASE_URL + '/saveOrderProcessDays',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      // r = new mWizard("m_wizard", {
      //   startStep: 3
      // }
      toasterOptions();
      toastr.success( 'Saved successfully!', 'Order Process' )
      setTimeout( function ()
      {
        //window.location.href = BASE_URL+'/orders'
        //location.reload();


      }, 500 );

    }
  } );


}



var orderListWizard = {
  init: function ()
  {
    $( "#m_table_1_OrderListWizard" ).DataTable( {
      responsive: !0,
      dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
      searchDelay: 1000,
      processing: !0,
      serverSide: !0,
      ajax: {

        url: BASE_URL + '/getOrderWizardList',
        type: "POST",
        data: {
          columnsDef: [ "RecordID", "Qty", "client_email", "process_wizard", "order_repeat", "item_name", "form_id", "artwork_status", "artwork_start_date", "order_id", "sub_order_id", "brand_name", "order_type", "created_by", "created_on", "orderSteps", "Actions" ],
          '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

        }
      },
      columns: [ {
        data: "Actions"
      } ],
      columnDefs: [ {
        targets: 0,
        title: "Actions",
        orderable: !1,
        render: function ( a, e, t, n )
        {

          var pday = 0;
          var html = '';


          html += `<div class="container" style="background-color:#FFF">
               <h6 class="m-section__heading"> #OID:<b> ${ t.order_id }/${ t.sub_order_id }</b> Name:<b>${ t.item_name }</b> Date:<b> ${ moment( t.created_on, "YYYY-MM-DD" ).format( "Do MMM" ) }</b>         Brand:<b>${ t.brand_name }</b>        Sales:<b>${ t.created_by }</b> Order Type:<b>${ t.order_type }</b> Order:<b>${ t.order_repeat }</b></h6>
                      <ul class="progress-indicator">`;

          $.each( t.orderSteps, function ( key, data )
          {
            i++;
            console.log( t.Qty );


            pday = parseInt( pday ) + parseInt( data.process_days );
            var disBubble = 'style="pointer-events:none;opacity:0.4';
            var new_date = moment( t.artwork_start_date, "YYYY-MM-DD" ).add( pday, 'days' ).format( "DD MMM" );
            var expected_date = moment( t.artwork_start_date, "YYYY-MM-DD" ).add( pday, 'days' ).format( "YYYY-MM-DD" );
            if ( parseInt( data.next_STEP ) > 1 )
            {
              new_date_ = new_date
            } else
            {
              new_date_ = "";
            }
            var stepD = 0;
            if ( parseInt( data.step_done ) == 1 )
            {
              stepD = 1;
            }
            //=====================================================================================


            if ( parseInt( data.sales_User_permission ) == parseInt( data.sales_Userornot ) && parseInt( data.sales_Userornot ) == 1 )
            {
              html += `<li class="${ data.color_code }"   >
                      <a href="javascript::void(0)" onclick="taskModal(${ t.form_id },${ data.order_step },'${ data.process_name }',${ data.process_days },'${ expected_date }',${ stepD },'${ data.step_code }','${ t.client_email }')" style="text-decoration-line:none">
                                                <span  class="bubble"></span>
                                              ${ data.process_name }<br>
                                              ${ new_date_ }
                                                </a>
                      </li>`;
            } else
            {
              if ( _UNIB_RIGHT == 'Admin' )
              {
                html += `<li class="${ data.color_code }"    >
                      <a href="javascript::void(0)" onclick="taskModal(${ t.form_id },${ data.order_step },'${ data.process_name }',${ data.process_days },'${ expected_date }',${ stepD },'${ data.step_code }','${ t.client_email }')" style="text-decoration-line:none">
                                                <span  class="bubble"></span>
                                              ${ data.process_name }<br>
                                              ${ new_date_ }
                                                </a>
                      </li>`;
              } else
              {
                if ( parseInt( data.pOrderUpdate ) == 1 )
                {
                  html += `<li class="${ data.color_code }" >
                      <a href="javascript::void(0)" onclick="taskModal(${ t.form_id },${ data.order_step },'${ data.process_name }',${ data.process_days },'${ expected_date }',${ stepD },'${ data.step_code }','${ t.client_email }')" style="text-decoration-line:none">
                                                <span  class="bubble"></span>
                                              ${ data.process_name }<br>
                                              ${ new_date_ }
                                                </a>
                      </li>`;
                } else
                {
                  if ( parseInt( data.assign_userid ) == parseInt( UID ) )
                  {
                    html += `<li class="${ data.color_code }"  >
                        <a href="javascript::void(0)" onclick="taskModal(${ t.form_id },${ data.order_step },'${ data.process_name }',${ data.process_days },'${ expected_date }',${ stepD },'${ data.step_code }','${ t.client_email }')" style="text-decoration-line:none">
                                                  <span  class="bubble"></span>
                                                ${ data.process_name }<br>
                                                ${ new_date_ }
                                                  </a>
                        </li>`;
                  } else
                  {
                    html += `<li class="${ data.color_code }" ${ disBubble }  >
                        <a href="javascript::void(0)" onclick="taskModal(${ t.form_id },${ data.order_step },'${ data.process_name }',${ data.process_days },'${ expected_date }',${ stepD },'${ data.step_code }','${ t.client_email }')" style="text-decoration-line:none">
                                                  <span  class="bubble"></span>
                                                ${ data.process_name }<br>
                                                ${ new_date_ }
                                                  </a>
                        </li>`;
                  }


                }

              }

            }
            //=====================================================================================



          } )

          html += `</ul></div>`;
          return html;


        }
      } ]
    } )
  }
};


var DatatablesAdvancedFooterCalllback_INCDATA = {
  init: function ()
  {

    $( "#m_table_1_INCDetails" ).DataTable( {
      responsive: !0,
      pageLength: 1000,
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
          u = o.column( 4 ).data().reduce( function ( t, e )
          {
            return l( t ) + l( e )
          }, 0 ),
          i = o.column( 4, {
            page: "current"
          } ).data().reduce( function ( t, e )
          {
            return l( t ) + l( e )
          }, 0 );
        $( o.column( 4 ).footer() ).html( "<b>" + mUtil.numberString( i.toFixed( 0 ) ) + "</b><br/> " )
      }
    } )
  }
};


var DatatablesAdvancedFooterCalllback_INCDATA_5245 = {
  init: function ()
  {

    $( "#m_table_1_CPInvoivxe" ).DataTable( {
      responsive: !0,
      pageLength: 10,
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
          u = o.column( 4 ).data().reduce( function ( t, e )
          {
            return l( t ) + l( e )
          }, 0 ),
          i = o.column( 4, {
            page: "current"
          } ).data().reduce( function ( t, e )
          {
            return l( t ) + l( e )
          }, 0 );
        $( o.column( 4 ).footer() ).html( "" + mUtil.numberString( i.toFixed( 2 ) ) + "<br/> ( " + mUtil.numberString( u.toFixed( 2 ) ) + " total)" )
      }
    } )
  }
};

jQuery( document ).ready( function ()
{
  DatatablesAdvancedFooterCalllback_INCDATA.init()
  DatatablesAdvancedFooterCalllback_INCDATA_5245.init()
} );


//inceetive footer 

//ajnewcode order
var DatatablesOrderStageBO = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_1_AK" ).DataTable( {
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

          url: BASE_URL + '/getOrderWizardList',
          type: "POST",
          data: {
            columnsDef: [ "RecordID", "Qty", "client_email", "process_wizard", "order_repeat", "order_id_withsub", "item_name", "form_id", "artwork_status", "artwork_start_date", "order_id", "sub_order_id", "brand_name", "order_type", "created_by", "created_on", "orderSteps", "Actions" ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

          }
        },
        columns: [ {
          data: "Actions"
        }, {
          data: "order_id_withsub"
        }, {
          data: "item_name"
        }, {
          data: "brand_name"
        }, {
          data: "order_type"
        }, {
          data: "created_by"
        },
        {
          data: "form_id"
        }, ],
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
        columnDefs: [
          {
            targets: [ 1, 2, 3, 4, 5, 6 ],
            visible: false,
            searchable: true
          },
          {
            targets: 0,
            title: "Actions",
            width: 980,
            orderable: !1,
            render: function ( a, e, t, n )
            {
              //console.log(t.Qty);
              var pday = 0;
              var html = '';
              var qclin = 'print/qcform/' + t.form_id;

              html += `<div class="container" style="background-color:#FFF">
                 <h6 class="m-section__heading"> #OID:<b> ${ t.order_id }/${ t.sub_order_id }</b> Name:<b>${ t.item_name }</b> Date:<b> ${ moment( t.created_on, "YYYY-MM-DD" ).format( "Do MMM" ) }</b>         Brand:<b>${ t.brand_name }</b>        Sales:<b>${ t.created_by }</b> Order Type:<b>${ t.order_type }</b> Order:<b>${ t.order_repeat }</b> <a style="text-decoration:none" title="view QC FORM" href="${ qclin }" target="_blank"><i class="flaticon-clipboard"></i></a></h6>
                        <ul class="progress-indicator">`;

              $.each( t.orderSteps, function ( key, data )
              {
                i++;
                //console.log(t);
                pday = parseInt( pday ) + parseInt( data.process_days );
                var disBubble = 'style="pointer-events:none;opacity:0.4';
                var new_date = moment( t.artwork_start_date, "YYYY-MM-DD" ).add( pday, 'days' ).format( "DD MMM" );
                var expected_date = moment( t.artwork_start_date, "YYYY-MM-DD" ).add( pday, 'days' ).format( "YYYY-MM-DD" );
                if ( parseInt( data.next_STEP ) > 1 )
                {
                  new_date_ = new_date
                } else
                {
                  new_date_ = "";
                }
                var stepD = 0;
                if ( parseInt( data.step_done ) == 1 )
                {
                  stepD = 1;
                }
                var aj_class = data.order_step + 'Aj' + t.form_id;
                //=====================================================================================


                if ( parseInt( data.sales_User_permission ) == parseInt( data.sales_Userornot ) && parseInt( data.sales_Userornot ) == 1 )
                {
                  html += `<li id="${ aj_class }" class="${ data.color_code }"   >
                        <a href="javascript::void(0)" onclick="taskModal(${ t.form_id },${ data.order_step },'${ data.process_name }',${ data.process_days },'${ expected_date }',${ stepD },'${ data.step_code }','${ t.client_email }',${ t.Qty })" style="text-decoration-line:none">
                                                  <span  class="bubble"></span>
                                                ${ data.process_name }<br>
                                                ${ new_date_ }
                                                  </a>
                        </li>`;
                } else
                {
                  if ( _UNIB_RIGHT == 'Admin' )
                  {
                    html += `<li id="${ aj_class }"  class="${ data.color_code }"    >
                        <a href="javascript::void(0)" onclick="taskModal(${ t.form_id },${ data.order_step },'${ data.process_name }',${ data.process_days },'${ expected_date }',${ stepD },'${ data.step_code }','${ t.client_email }',${ t.Qty })" style="text-decoration-line:none">
                                                  <span  class="bubble"></span>
                                                ${ data.process_name }<br>
                                                ${ new_date_ }
                                                  </a>
                        </li>`;
                  } else
                  {
                    if ( parseInt( data.pOrderUpdate ) == 1 )
                    {
                      html += `<li id="${ aj_class }" class="${ data.color_code }" >
                        <a href="javascript::void(0)" onclick="taskModal(${ t.form_id },${ data.order_step },'${ data.process_name }',${ data.process_days },'${ expected_date }',${ stepD },'${ data.step_code }','${ t.client_email }',${ t.Qty })" style="text-decoration-line:none">
                                                  <span  class="bubble"></span>
                                                ${ data.process_name }<br>
                                                ${ new_date_ }
                                                  </a>
                        </li>`;
                    } else
                    {
                      if ( parseInt( data.assign_userid ) == parseInt( UID ) )
                      {
                        html += `<li id="${ aj_class }"  class="${ data.color_code }"  >
                          <a href="javascript::void(0)" onclick="taskModal(${ t.form_id },${ data.order_step },'${ data.process_name }',${ data.process_days },'${ expected_date }',${ stepD },'${ data.step_code }','${ t.client_email }',${ t.Qty })" style="text-decoration-line:none">
                                                    <span  class="bubble"></span>
                                                  ${ data.process_name }<br>
                                                  ${ new_date_ }
                                                    </a>

                          </li>`;
                      } else
                      {
                        if ( parseInt( data.step_done ) == 1 )
                        {
                          html += `<li id="${ aj_class }" class="${ data.color_code }"  >
                            <a href="javascript::void(0)" onclick="taskModal(${ t.form_id },${ data.order_step },'${ data.process_name }',${ data.process_days },'${ expected_date }',${ stepD },'${ data.step_code }','${ t.client_email }',${ t.Qty })" style="text-decoration-line:none">
                                                      <span  class="bubble"></span>
                                                    ${ data.process_name }<br>
                                                    ${ new_date_ }
                                                      </a>
                            </li>`;
                        } else
                        {
                          html += `<li id="${ aj_class }" class="${ data.color_code }" ${ disBubble }  >
                          <a href="javascript::void(0)" onclick="taskModal(${ t.form_id },${ data.order_step },'${ data.process_name }',${ data.process_days },'${ expected_date }',${ stepD },'${ data.step_code }','${ t.client_email }',${ t.Qty })" style="text-decoration-line:none">
                                                    <span  class="bubble"></span>
                                                  ${ data.process_name }<br>
                                                  ${ new_date_ }
                                                    </a>
                          </li>`;
                        }



                      }


                    }

                  }

                }
                //=====================================================================================



              } )

              html += `</ul></div>`;
              return html;


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

//ajnewcode order

jQuery( document ).ready( function ()
{
  // orderListWizard.init();
  DatatablesOrderStageBO.init();

} );

$( '#dispatch_div' ).hide();
//statge
function taskModal( orderid, step_id, orderString, process_days, expected_date, stepdoneStatus, step_code, client_email, Qty )
{
  //alert(Qty);

  $( '#txtClientEmail' ).val( client_email );
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

        var htmlACompleted = '';
        htmlACompleted += `<div class="m-portlet">
      <div class="m-portlet__body">
        <!--begin::Section-->
        <div class="m-section">
          <div class="m-section__content">
            <table class="table table-sm m-table m-table--head-bg-brand">
              <thead class="thead-inverse">
                <tr>
                  <th>Stage Name</th>
                  <th>Completed on</th>
                  <th>Completed by</th>
                </tr>
              </thead>
              <tbody>`;



        $.each( res.alldata, function ( key, dataC )
        {
          console.log( dataC.stage_name );
          htmlACompleted += `<tr>
        <td>${ dataC.stage_name }</td>
        <td>${ dataC.completed_on }</td>
        <td>${ dataC.completed_by }</td>
      </tr>`;

        } );

        htmlACompleted += `</tbody>
      </table>
    </div>
  </div>
</div>
</div>`;


        var htmlAComments = '';
        htmlAComments += `<div class="m-portlet">
      <div class="m-portlet__body">
        <!--begin::Section-->
        <div class="m-section">
          <div class="m-section__content">
            <table class="table table-sm m-table m-table--head-bg-brand">
              <thead class="thead-inverse">
                <tr>
                  <th>Stage Name</th>
                  <th>Comments</th>
                  <th>Completed by</th>
                  <th>Completed on</th>
                </tr>
              </thead>
              <tbody>`;



        $.each( res.dataComments, function ( key, dataC )
        {
          // console.log(dataC.stage_name);
          htmlAComments += `<tr>
        <td>${ dataC.StageNo }</td>
        <td>${ dataC.Comments }</td>
        <td>${ dataC.completed_by }</td>
        <td>${ dataC.completed_on }</td>
      </tr>`;

        } );

        htmlAComments += `</tbody>
      </table>
    </div>
  </div>
</div>
</div>`;






        $( '#m_tabs_1_1_ajcompleted' ).html( htmlACompleted );
        $( '#m_tabs_1_1_ajcommments' ).html( htmlAComments );


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

        //$('#showProDateHere').html(htmlA);



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


$( '#btnProcessComment' ).click( function ()
{
  var orderComment = $( '#orderComment' ).val();
  var txtorderStepID = $( '#txtorderStepID' ).val();
  var txtOrderID_FORMID = $( '#txtOrderID_FORMID' ).val();
  var txtProcess_days = $( '#txtProcess_days' ).val();
  var txtProcess_Name = $( '#txtProcess_Name' ).val();
  var txtStepCode = $( '#txtStepCode' ).val();

  var order_crated_by = $( "#order_crated_by option:selected" ).val();

  toasterOptions();
  if ( orderComment == "" )
  {
    toastr.warning( 'Enter Process Comment', 'Order Process Wizard' );
    return true;
  }

  //ajax call
  var formData = {
    'orderComment': orderComment,
    'txtorderStepID': txtorderStepID,
    'txtOrderID_FORMID': txtOrderID_FORMID,
    'txtProcess_days': txtProcess_days,
    'txtProcess_Name': txtProcess_Name,
    'txtStepCode': txtStepCode,
    'assign_user': order_crated_by,
    'order_process_type': 'comment',
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/save_order_process',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toastr.success( 'Successfully added Comment', 'Order Process Wizard' );
        //location.reload(1);

      }
    },
    dataType: 'json'
  } );
  //ajax call





} );

$( '#btnProcessComment1' ).click( function ()
{
  var orderComment = $( '#orderComment1' ).val();
  var txtorderStepID = $( '#txtorderStepID1' ).val();
  var txtOrderID_FORMID = $( '#txtOrderID_FORMID1' ).val();
  var txtProcess_days = $( '#txtProcess_days1' ).val();
  var txtProcess_Name = $( '#txtProcess_Name1' ).val();
  var txtStepCode = $( '#txtStepCode1' ).val();

  var order_crated_by = $( "#order_crated_by option:selected" ).val();

  toasterOptions();
  if ( orderComment == "" )
  {
    toastr.warning( 'Enter Process Comment', 'Order Process Wizard' );
    return true;
  }

  //ajax call
  var formData = {
    'orderComment': orderComment,
    'txtorderStepID': txtorderStepID,
    'txtOrderID_FORMID': txtOrderID_FORMID,
    'txtProcess_days': txtProcess_days,
    'txtProcess_Name': txtProcess_Name,
    'txtStepCode': txtStepCode,
    'assign_user': order_crated_by,
    'order_process_type': 'comment',
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/save_order_process_dispatch_comment',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toastr.success( 'Successfully added Comment', 'Order Process Wizard' );
        location.reload( 1 );

      }
    },
    dataType: 'json'
  } );
  //ajax call





} );

//
$( '#btnProcessComment_Filter' ).click( function ()
{
  var orderComment = $( '#orderCommentA' ).val();
  var txtorderStepID = $( '#txtorderStepID' ).val();
  var txtOrderID_FORMID = $( '#txtOrderID_FORMID' ).val();
  var txtProcess_days = $( '#txtProcess_days' ).val();
  var txtProcess_Name = $( '#txtProcess_Name' ).val();
  var txtStepCode = $( '#txtStepCode' ).val();

  var order_crated_by = $( "#order_crated_by option:selected" ).val();

  toasterOptions();
  if ( orderComment == "" )
  {
    toastr.warning( 'Enter Process Comment', 'Order Process Wizard' );
    return true;
  }

  //ajax call
  var formData = {
    'orderComment': orderComment,
    'txtorderStepID': txtorderStepID,
    'txtOrderID_FORMID': txtOrderID_FORMID,
    'txtProcess_days': txtProcess_days,
    'txtProcess_Name': txtProcess_Name,
    'txtStepCode': txtStepCode,
    'assign_user': order_crated_by,
    'order_process_type': 'comment',
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };



  $.ajax( {
    url: BASE_URL + '/save_order_process',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toastr.success( 'Successfully added Comment', 'Order Process Wizard' );
        location.reload( 1 );

      }
    },
    dataType: 'json'
  } );
  //ajax call





} );

//btnProcessComment_Filter



// btnProcessComplete_Filter
$( '#btnProcessComplete_Filter' ).click( function ()
{
  var orderComment = $( '#orderComment' ).val();
  var txtorderStepID = $( '#txtorderStepID' ).val();
  var txtOrderID_FORMID = $( '#txtOrderID_FORMID' ).val();
  var txtProcess_days = $( '#txtProcess_days' ).val();
  var txtProcess_Name = $( '#txtProcess_Name' ).val();
  var txtStepCode = $( '#txtStepCode' ).val();
  var expectedDate = $( '#expectedDate' ).val();
  var order_crated_by = $( "#order_crated_by option:selected" ).val();

  //----------------------
  var txtLRNo = $( '#txtLRNo' ).val();
  var txtTransport = $( '#txtTransport' ).val();
  var txtCartons = $( '#txtCartons' ).val();
  var txtCartonsEachUnit = $( '#txtCartonsEachUnit' ).val();
  var txtTotalUnit = $( '#txtTotalUnit' ).val();

  var txtBookingFor = $( '#txtBookingFor' ).val();
  var txtPONumber = $( '#txtPONumber' ).val();
  var txtInvoice = $( '#txtInvoice' ).val();
  var client_notify = $( '#client_notify' ).val();
  var txtClientEmail = $( '#txtClientEmail' ).val();
  var favorite = [];

  $.each( $( "input[name='client_notify']:checked" ), function ()
  {

    favorite.push( $( this ).val() );

  } );
  function IsEmail( email )
  {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !regex.test( email ) )
    {
      return false;
    } else
    {
      return true;
    }
  }

  if ( txtStepCode == 'DISPATCH_ORDER' )
  {
    if ( favorite.join( "," ) == 1 )
    {
      if ( txtClientEmail == "" || txtClientEmail == 'null' )
      {
        toastr.warning( 'Email Required', 'Order Process Wizard' );
        return false;
      }

      if ( IsEmail( txtClientEmail ) == false )
      {
        toastr.warning( 'Invalid Email', 'Order Process Wizard' );
        return false;
      }

    }
  }



  //----------------------

  toasterOptions();
  if ( orderComment == "" )
  {
    toastr.warning( 'Enter Process Comment', 'Order Process Wizard' );
    //return true;
  }

  //ajax call
  var formData = {
    'orderComment': orderComment,
    'txtorderStepID': txtorderStepID,
    'txtOrderID_FORMID': txtOrderID_FORMID,
    'txtProcess_days': txtProcess_days,
    'txtProcess_Name': txtProcess_Name,
    'txtStepCode': txtStepCode,
    'assign_user': order_crated_by,
    'expectedDate': expectedDate,
    'order_process_type': 'done',
    'txtLRNo': txtLRNo,
    'txtTransport': txtTransport,
    'txtCartons': txtCartons,
    'txtCartonsEachUnit': txtCartonsEachUnit,
    'txtTotalUnit': txtTotalUnit,
    'txtBookingFor': txtBookingFor,
    'txtPONumber': txtPONumber,
    'txtInvoice': txtInvoice,
    'client_notify': client_notify,
    'txtClientEmail': txtClientEmail,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/save_order_process',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toastr.success( 'Completed', 'Order Process Wizard' );
        //live status
        var myid = '#' + txtorderStepID + 'Aj' + txtOrderID_FORMID;
        var today = moment().format( "YYYY-MM-DD" );
        if ( moment( today ).isBefore( expectedDate, 'year-month-day' ) )
        {
          class_name = "completed";
        } else
        {
          class_name = "danger";
        }
        // if(parseInt(txtorderStepID)==1){
        //   class_name="completed";
        // }
        $( myid ).removeClass( "" );
        $( myid ).addClass( class_name );
        //live status

        location.reload( 1 );
        $( '#m_modal_5_orderComment' ).modal( 'hide' );

      }
    },
    dataType: 'json'
  } );
  //ajax call


} );

//btnProcessComplete_OrderList



$( '#btnProcessComplete_OrderList' ).click( function ()
{
  var orderComment = $( '#orderComment' ).val();
  var txtorderStepID = $( '#txtorderStepID' ).val();
  var txtOrderID_FORMID = $( '#txtOrderID_FORMID' ).val();
  var txtProcess_days = $( '#txtProcess_days' ).val();
  var txtProcess_Name = $( '#txtProcess_Name' ).val();
  var txtStepCode = $( '#txtStepCode' ).val();
  var expectedDate = $( '#expectedDate' ).val();
  var order_crated_by = $( "#order_crated_by option:selected" ).val();

  //----------------------
  var txtLRNo = $( '#txtLRNo' ).val();
  var txtTransport = $( '#txtTransport' ).val();
  var txtCartons = $( '#txtCartons' ).val();
  var txtCartonsEachUnit = $( '#txtCartonsEachUnit' ).val();
  var txtTotalUnit = $( '#txtTotalUnit' ).val();

  var txtBookingFor = $( '#txtBookingFor' ).val();
  var txtPONumber = $( '#txtPONumber' ).val();
  var txtInvoice = $( '#txtInvoice' ).val();
  var client_notify = $( '#client_notify' ).val();
  var txtClientEmail = $( '#txtClientEmail' ).val();
  var favorite = [];

  $.each( $( "input[name='client_notify']:checked" ), function ()
  {

    favorite.push( $( this ).val() );

  } );
  function IsEmail( email )
  {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !regex.test( email ) )
    {
      return false;
    } else
    {
      return true;
    }
  }

  if ( txtStepCode == 'DISPATCH_ORDER' )
  {
    if ( favorite.join( "," ) == 1 )
    {
      if ( txtClientEmail == "" || txtClientEmail == 'null' )
      {
        toastr.warning( 'Email Required', 'Order Process Wizard' );
        return false;
      }

      if ( IsEmail( txtClientEmail ) == false )
      {
        toastr.warning( 'Invalid Email', 'Order Process Wizard' );
        return false;
      }

    }
  }



  //----------------------

  toasterOptions();
  if ( orderComment == "" )
  {
    toastr.warning( 'Enter Process Comment', 'Order Process Wizard' );
    //return true;
  }

  //ajax call
  var formData = {
    'orderComment': orderComment,
    'txtorderStepID': txtorderStepID,
    'txtOrderID_FORMID': txtOrderID_FORMID,
    'txtProcess_days': txtProcess_days,
    'txtProcess_Name': txtProcess_Name,
    'txtStepCode': txtStepCode,
    'assign_user': order_crated_by,
    'expectedDate': expectedDate,
    'order_process_type': 'done',
    'txtLRNo': txtLRNo,
    'txtTransport': txtTransport,
    'txtCartons': txtCartons,
    'txtCartonsEachUnit': txtCartonsEachUnit,
    'txtTotalUnit': txtTotalUnit,
    'txtBookingFor': txtBookingFor,
    'txtPONumber': txtPONumber,
    'txtInvoice': txtInvoice,
    'client_notify': client_notify,
    'txtClientEmail': txtClientEmail,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/save_order_process',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toastr.success( 'Completed', 'Order Process Wizard' );
        //live status
        var myid = '#' + txtorderStepID + 'Aj' + txtOrderID_FORMID;
        var today = moment().format( "YYYY-MM-DD" );
        if ( moment( today ).isBefore( expectedDate, 'year-month-day' ) )
        {
          class_name = "completed";
        } else
        {
          class_name = "danger";
        }
        // if(parseInt(txtorderStepID)==1){
        //   class_name="completed";
        // }
        $( myid ).removeClass( "" );
        $( myid ).addClass( class_name );
        //live status

        // location.reload(1);
        $( '#m_modal_5_orderComment' ).modal( 'hide' );

      }
    },
    dataType: 'json'
  } );
  //ajax call


} );




$( '#btnProcessComplete' ).click( function ()
{
  var orderComment = $( '#orderComment' ).val();
  var txtorderStepID = $( '#txtorderStepID' ).val();
  var txtOrderID_FORMID = $( '#txtOrderID_FORMID' ).val();
  var txtProcess_days = $( '#txtProcess_days' ).val();
  var txtProcess_Name = $( '#txtProcess_Name' ).val();
  var txtStepCode = $( '#txtStepCode' ).val();
  var expectedDate = $( '#expectedDate' ).val();
  var order_crated_by = $( "#order_crated_by option:selected" ).val();

  //----------------------
  var txtLRNo = $( '#txtLRNo' ).val();
  var txtTransport = $( '#txtTransport' ).val();
  var txtCartons = $( '#txtCartons' ).val();
  var txtCartonsEachUnit = $( '#txtCartonsEachUnit' ).val();
  var txtTotalUnit = $( '#txtTotalUnit' ).val();

  var txtBookingFor = $( '#txtBookingFor' ).val();
  var txtPONumber = $( '#txtPONumber' ).val();
  var txtInvoice = $( '#txtInvoice' ).val();
  var client_notify = $( '#client_notify' ).val();
  var txtClientEmail = $( '#txtClientEmail' ).val();
  var favorite = [];

  $.each( $( "input[name='client_notify']:checked" ), function ()
  {

    favorite.push( $( this ).val() );

  } );
  function IsEmail( email )
  {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !regex.test( email ) )
    {
      return false;
    } else
    {
      return true;
    }
  }

  if ( txtStepCode == 'DISPATCH_ORDER' )
  {
    if ( favorite.join( "," ) == 1 )
    {
      if ( txtClientEmail == "" || txtClientEmail == 'null' )
      {
        toastr.warning( 'Email Required', 'Order Process Wizard' );
        return false;
      }

      if ( IsEmail( txtClientEmail ) == false )
      {
        toastr.warning( 'Invalid Email', 'Order Process Wizard' );
        return false;
      }

    }
  }



  //----------------------

  toasterOptions();
  if ( orderComment == "" )
  {
    toastr.warning( 'Enter Process Comment', 'Order Process Wizard' );
    return true;
  }

  //ajax call
  var formData = {
    'orderComment': orderComment,
    'txtorderStepID': txtorderStepID,
    'txtOrderID_FORMID': txtOrderID_FORMID,
    'txtProcess_days': txtProcess_days,
    'txtProcess_Name': txtProcess_Name,
    'txtStepCode': txtStepCode,
    'assign_user': order_crated_by,
    'expectedDate': expectedDate,
    'order_process_type': 'done',
    'txtLRNo': txtLRNo,
    'txtTransport': txtTransport,
    'txtCartons': txtCartons,
    'txtCartonsEachUnit': txtCartonsEachUnit,
    'txtTotalUnit': txtTotalUnit,
    'txtBookingFor': txtBookingFor,
    'txtPONumber': txtPONumber,
    'txtInvoice': txtInvoice,
    'client_notify': client_notify,
    'txtClientEmail': txtClientEmail,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/save_order_process',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toastr.success( 'Completed', 'Order Process Wizard' );
        //live status
        var myid = '#' + txtorderStepID + 'Aj' + txtOrderID_FORMID;
        var today = moment().format( "YYYY-MM-DD" );
        if ( moment( today ).isBefore( expectedDate, 'year-month-day' ) )
        {
          class_name = "completed";
        } else
        {
          class_name = "danger";
        }
        // if(parseInt(txtorderStepID)==1){
        //   class_name="completed";
        // }
        $( myid ).removeClass( "" );
        $( myid ).addClass( class_name );
        //live status

        // location.reload(1);
        $( '#m_modal_5_orderComment' ).modal( 'hide' );

      }
    },
    dataType: 'json'
  } );
  //ajax call


} );


$( '#btnProcessComplete1' ).click( function ()
{
  var orderComment = $( '#orderComment' ).val();
  var txtorderStepID = $( '#txtorderStepID' ).val();
  var txtOrderID_FORMID = $( '#txtOrderID_FORMID' ).val();
  var txtProcess_days = $( '#txtProcess_days' ).val();
  var txtProcess_Name = $( '#txtProcess_Name' ).val();
  var txtStepCode = $( '#txtStepCode' ).val();
  var expectedDate = $( '#expectedDate' ).val();
  var order_crated_by = $( "#order_crated_by option:selected" ).val();

  //----------------------
  var txtLRNo = $( '#txtLRNo' ).val();
  var txtTransport = $( '#txtTransport' ).val();
  var txtCartons = $( '#txtCartons' ).val();
  var txtCartonsEachUnit = $( '#txtCartonsEachUnit' ).val();
  var txtTotalUnit = $( '#txtTotalUnit' ).val();

  var txtBookingFor = $( '#txtBookingFor' ).val();
  var txtPONumber = $( '#txtPONumber' ).val();
  var txtInvoice = $( '#txtInvoice' ).val();
  var client_notify = $( '#client_notify' ).val();
  var txtClientEmail = $( '#txtClientEmail' ).val();
  var favorite = [];

  $.each( $( "input[name='client_notify']:checked" ), function ()
  {

    favorite.push( $( this ).val() );

  } );
  function IsEmail( email )
  {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if ( !regex.test( email ) )
    {
      return false;
    } else
    {
      return true;
    }
  }

  if ( txtStepCode == 'DISPATCH_ORDER' )
  {
    if ( favorite.join( "," ) == 1 )
    {
      if ( txtClientEmail == "" || txtClientEmail == 'null' )
      {
        toastr.warning( 'Email Required', 'Order Process Wizard' );
        return false;
      }

      if ( IsEmail( txtClientEmail ) == false )
      {
        toastr.warning( 'Invalid Email', 'Order Process Wizard' );
        return false;
      }

    }
  }



  //----------------------

  toasterOptions();
  if ( orderComment == "" )
  {
    toastr.warning( 'Enter Process Comment', 'Order Process Wizard' );
    return true;
  }

  //ajax call
  var formData = {
    'orderComment': orderComment,
    'txtorderStepID': txtorderStepID,
    'txtOrderID_FORMID': txtOrderID_FORMID,
    'txtProcess_days': txtProcess_days,
    'txtProcess_Name': txtProcess_Name,
    'txtStepCode': txtStepCode,
    'assign_user': order_crated_by,
    'expectedDate': expectedDate,
    'order_process_type': 'done',
    'txtLRNo': txtLRNo,
    'txtTransport': txtTransport,
    'txtCartons': txtCartons,
    'txtCartonsEachUnit': txtCartonsEachUnit,
    'txtTotalUnit': txtTotalUnit,
    'txtBookingFor': txtBookingFor,
    'txtPONumber': txtPONumber,
    'txtInvoice': txtInvoice,
    'client_notify': client_notify,
    'txtClientEmail': txtClientEmail,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/save_order_process',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      if ( res.status == 1 )
      {
        toastr.success( 'Completed', 'Order Process Wizard' );
        // location.reload(1);
        $( '#m_modal_5_orderComment' ).modal( 'hide' );

      }
    },
    dataType: 'json'
  } );
  //ajax call


} );


/*
  //==============================================
                  if(parseInt(data.assign_userid)==parseInt(UID)){
                    //assign persion node
                    //-------------------------------------
                    if(parseInt(data.step_done)==1){
                      html +=`<li class="${data.color_code}" ${disBubble} >
                    <a href="javascript::void(0)" onclick="taskModal(${t.form_id},${data.order_step},'${data.process_name}',${data.process_days},'${expected_date}')" style="text-decoration-line:none">
                                              <span  class="bubble"></span>
                                            ${data.process_name}<br>
                                            ${new_date}
                                              </a>
                    </li>`;
                    }else{
                      if(parseInt(data.order_step)==parseInt(data.next_STEP)){
                        html +=`<li class="" >
                        <a href="javascript::void(0)" onclick="taskModal(${t.form_id},${data.order_step},'${data.process_name}',${data.process_days},'${expected_date}')" style="text-decoration-line:none">
                                                  <span  class="bubble"></span>
                                                ${data.process_name}<br>
                                                ${new_date}
                                                  </a>
                        </li>`;
                      }else{
                        html +=`<li class="" ${disBubble} >
                        <a href="javascript::void(0)" onclick="taskModal(${t.form_id},${data.order_step},'${data.process_name}',${data.process_days},'${expected_date}')" style="text-decoration-line:none">
                                                  <span  class="bubble"></span>
                                                ${data.process_name}<br>
                                                ${new_date}
                                                  </a>
                        </li>`;
                      }

                    }
                    //-------------------------------------

                  }else{
                     //none assign persion node
                      html +=`<li class=""  ${disBubble} >
                      <a href="javascript::void(0)" onclick="taskModal(${t.form_id},${data.order_step},'${data.process_name}',${data.process_days},'${expected_date}')" style="text-decoration-line:none">
                                                <span  class="bubble"></span>
                                              ${data.process_name}<br>
                                              ${new_date}
                                                </a>
                      </li>`;
                  }
                   //==============================================
                   var orderListWizard = {
  init: function() {
      $("#m_table_1_OrderListWizard").DataTable({
          responsive: !0,
          dom: "<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
          searchDelay: 500,
          processing: !0,
          serverSide: !0,
          ajax: {

            url:BASE_URL+'/getOrderWizardList',
            type: "POST",
            data: {
                columnsDef: ["RecordID","process_wizard","form_id","order_id","sub_order_id","brand_name", "created_by", "created_on","orderSteps","Actions"],
                '_token':$('meta[name="csrf-token"]').attr('content')

            }
        },
          columns: [ {
              data: "Actions"
          }],
          columnDefs: [{
              targets: 0,
              title: "Actions",
              orderable: !1,
              render: function(a, e, t, n) {

              var pday=0;
              var html='';
              html +=`<div class="container" style="background-color:#FFF">
               <h6 class="m-section__heading"> Order ID:<b> ${t.order_id}/${t.sub_order_id}</b>         Brand:<b>${t.brand_name}</b>        Sales Person:<b>${t.created_by}</b></h6>
                      <ul class="progress-indicator">`;

                $.each(t.orderSteps, function (key, data) {
                i++;
               // console.log(t.orderSteps);
                pday =parseInt(pday)+parseInt(data.process_days);

                //style="pointer-events:none;opacity:0.4;
                var disBubble='style="pointer-events:none;opacity:0.4';

                var new_date = moment(t.created_on, "YYYY-MM-DD").add(pday, 'days').format("DD MMM ");
                var expected_date = moment(t.created_on, "YYYY-MM-DD").add(pday, 'days').format("YYYY-MM-DD ");
                 //==============================================
                      var stepD=0;
                      if(parseInt(data.step_done)==1){
                         stepD=1;
                      }
                  if(parseInt(data.assign_userid)==parseInt(UID)){


                    if(parseInt(data.order_step)==1){
                      html +=`<li class="${data.color_code}" >
                      <a href="javascript::void(0)" onclick="taskModal(${t.form_id},${data.order_step},'${data.process_name}',${data.process_days},'${expected_date}',${stepD})" style="text-decoration-line:none">
                                                <span  class="bubble"></span>
                                              ${data.process_name}<br>
                                              ${new_date}
                                                </a>
                      </li>`;

                    }else{
                      //check here the step 1 is done or not
                      if(parseInt(data.next_STEP) >1 ){
                        if(parseInt(data.order_step) <=6 ){
                          html +=`<li class="${data.color_code}" >
                          <a href="javascript::void(0)" onclick="taskModal(${t.form_id},${data.order_step},'${data.process_name}',${data.process_days},'${expected_date}',${stepD})" style="text-decoration-line:none">
                                                    <span  class="bubble"></span>
                                                  ${data.process_name}<br>
                                                  ${new_date}
                                                    </a>
                          </li>`;
                        }else{
                          if(parseInt(data.order_step)==parseInt(data.next_STEP)){
                            html +=`<li class="" >
                            <a href="javascript::void(0)" onclick="taskModal(${t.form_id},${data.order_step},'${data.process_name}',${data.process_days},'${expected_date}',${stepD})" style="text-decoration-line:none">
                                                      <span  class="bubble"></span>
                                                    ${data.process_name}<br>
                                                    ${new_date}
                                                      </a>
                            </li>`;
                          }else{

                            if( parseInt(data.step_done)==1){
                              html +=`<li class="${data.color_code}" >
                            <a href="javascript::void(0)" onclick="taskModal(${t.form_id},${data.order_step},'${data.process_name}',${data.process_days},'${expected_date}',${stepD})" style="text-decoration-line:none">
                                                      <span  class="bubble"></span>
                                                    ${data.process_name}<br>
                                                    ${new_date}
                                                      </a>
                            </li>`;
                            }else{
                              html +=`<li class="" ${disBubble} >
                            <a href="javascript::void(0)" onclick="taskModal(${t.form_id},${data.order_step},'${data.process_name}',${data.process_days},'${expected_date}',${stepD})" style="text-decoration-line:none">
                                                      <span  class="bubble"></span>
                                                    ${data.process_name}<br>
                                                    ${new_date}
                                                      </a>
                            </li>`;
                            }

                          }

                          // html +=`<li class="" ${disBubble}>
                          // <a href="javascript::void(0)" onclick="taskModal(${t.form_id},${data.order_step},'${data.process_name}',${data.process_days},'${expected_date}')" style="text-decoration-line:none">
                          //                           <span  class="bubble"></span>
                          //                         ${data.process_name}<br>
                          //                         ${new_date}
                          //                           </a>
                          // </li>`;
                        }

                      }else{
                        html +=`<li class="" ${disBubble} >
                        <a href="javascript::void(0)" onclick="taskModal(${t.form_id},${data.order_step},'${data.process_name}',${data.process_days},'${expected_date}',${stepD})" style="text-decoration-line:none">
                                                  <span  class="bubble"></span>
                                                ${data.process_name}<br>
                                                ${new_date}
                                                  </a>
                        </li>`;
                      }

                    }

                  }else{
                     //none assign persion node

                     if( parseInt(data.step_done)==1){
                      html +=`<li class=" ${data.color_code}"  >
                      <a href="javascript::void(0)" onclick="taskModal(${t.form_id},${data.order_step},'${data.process_name}',${data.process_days},'${expected_date}',${stepD})" style="text-decoration-line:none">
                                                <span  class="bubble"></span>
                                              ${data.process_name}<br>
                                              ${new_date}
                                                </a>
                      </li>`;
                     }else{
                      html +=`<li class=""  ${disBubble} >
                      <a href="javascript::void(0)" onclick="taskModal(${t.form_id},${data.order_step},'${data.process_name}',${data.process_days},'${expected_date}',${stepD})" style="text-decoration-line:none">
                                                <span  class="bubble"></span>
                                              ${data.process_name}<br>
                                              ${new_date}
                                                </a>
                      </li>`;
                     }

                  }
                   //==============================================


              })

              html +=`</ul></div>`;
              return html;


              }
          }]
      })
  }
};
jQuery(document).ready(function() {
  orderListWizard.init()
});
                  */



function showStageReportFilter( step_id, filter_by )
{
  //alert(step_id);
  //alert(filter_by);

}
function showStageReportFilterAll( filterType )
{

  var formData = {
    'filterType': filterType,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getStagesByTeamWithFilter',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '.ajrowShowStagesTeam' ).html( res );
    },

  } );


}




var Inputmask = {
  init: function ()
  {
    $( "#m_inputmask_1" ).inputmask( "mm/dd/yyyy", {
      autoUnmask: !0
    } ), $( "#m_inputmask_2" ).inputmask( "mm/dd/yyyy", {
      placeholder: "*"
    } ), $( "#m_inputmask_3" ).inputmask( "mask", {
      mask: "(999) 999-9999"
    } ), $( "#m_inputmask_4" ).inputmask( {
      mask: "99-9999999",
      placeholder: ""
    } ), $( "#m_inputmask_5" ).inputmask( {
      mask: "9",
      repeat: 10,
      greedy: !1
    } ), $( "#m_inputmask_6,#m_inputmask_67" ).inputmask( "decimal", {
      rightAlignNumerics: !1
    } ),
      $( "#m_inputmask_6A1" ).inputmask( "decimal", {
        rightAlignNumerics: !1
      } ),
      $( "#m_inputmask_6A2" ).inputmask( "decimal", {
        rightAlignNumerics: !1
      } ),
      $( "#m_inputmask_6A3" ).inputmask( "decimal", {
        rightAlignNumerics: !1
      } ),
      $( "#m_inputmask_6A4" ).inputmask( "decimal", {
        rightAlignNumerics: !1
      } ),
      $( "#m_inputmask_6A5" ).inputmask( "decimal", {
        rightAlignNumerics: !1
      } ),
      $( "#m_inputmask_6A5A" ).inputmask( "decimal", {
        leftAlignNumerics: !1
      } ),
      $( ".m_inputmask_6A5A" ).inputmask( "decimal", {
        leftAlignNumerics: !1
      } ),




      $( "#m_inputmask_7" ).inputmask( "€ 999.999.999,99", {
        numericInput: !0
      } ), $( "#m_inputmask_8" ).inputmask( {
        mask: "999.999.999.999"
      } ), $( "#m_inputmask_9" ).inputmask( {
        mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
        greedy: !1,
        onBeforePaste: function ( m, a )
        {
          return ( m = m.toLowerCase() ).replace( "mailto:", "" )
        },
        definitions: {
          "*": {
            validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~-]",
            cardinality: 1,
            casing: "lower"
          }
        }
      } )
  }
};
jQuery( document ).ready( function ()
{
  Inputmask.init()

  $( "input[name=txtMachineTime]" ).focusout( function ()
  {
    var manualTime = $( "input[name=txtManualTime]" ).val();
    var machineTime = $( "input[name=txtMachineTime]" ).val();
    var cycleTime = parseInt( manualTime ) + parseInt( machineTime );
    $( "input[name=txtoutputCycleTime]" ).val( cycleTime );

  } );
  $( "input[name=txtManualTime]" ).focusout( function ()
  {
    var manualTime = $( "input[name=txtManualTime]" ).val();
    var machineTime = $( "input[name=txtMachineTime]" ).val();
    var cycleTime = parseInt( manualTime ) + parseInt( machineTime );
    $( "input[name=txtoutputCycleTime]" ).val( cycleTime );

  } );


} );

//m_inputmask_6A1
function drawChart()
{
  // Define the chart to be drawn.


  // Instantiate and draw the chart.

}

// getLeadLMGraphFilter



function getLeadLMGraphFilter()
{

  var salesPerson = $( '#salesPerson' ).val();
  if ( salesPerson == "" )
  {
    toasterOptions();
    toastr.error( 'Select User', 'Lead Manger' )

  }
  var txtStages = $( '#txtStages' ).val();
  var txtMonth = $( "#txtMonth option:selected" ).val();
  var txtYear = $( "#txtyear option:selected" ).val();
  var lead_status = $( "#lead_status option:selected" ).val();

  var formData = {
    'salesPerson': salesPerson,
    'txtYear': txtYear,
    'txtMonth': txtMonth,
    'lead_status': lead_status,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  //ajax
  $.ajax( {
    url: BASE_URL + '/getFilterLeadLMReportCompleted',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      $.each( res, function ( key, value )
      {



        var data = google.visualization.arrayToDataTable( value.step_data );
        var options = {
          title: value.step_name + " Total:" + value.step_totalCount,

          seriesType: 'bars',
          series: { 1: { type: 'line' } },
          colors: [ '#008080', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6' ]
        };
        var dyamicID = value.step_code;

        var chart = new google.visualization.ComboChart( document.getElementById( dyamicID ) );
        chart.draw( data, options );
        google.charts.setOnLoadCallback( drawChart );



      } );
    },
    dataType: 'json'
  } );

  //ajax


}

//getLeadCallGraphFilter
function getLeadCallGraphFilter()
{

  var salesPerson = $( '#salesPerson' ).val();
  var txtMonth = $( '#txtMonth' ).val();
  var txtyear = $( '#txtyear' ).val();
  var formData = {
    'salesPerson': salesPerson,
    'txtMonth': txtMonth,
    'txtyear': txtyear,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  //ajax
  $.ajax( {
    url: BASE_URL + '/getFilterLeadCallCompleted',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      $.each( res, function ( key, value )
      {

        console.log( value.step_name );

        var data = google.visualization.arrayToDataTable( value.step_data );
        var options = {
          title: value.step_name + " Total:" + value.step_totalCount,

          seriesType: 'bars',
          series: { 1: { type: 'line' } },
          colors: [ '#008080', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6' ]
        };
        var dyamicID = value.step_code;
        var chart = new google.visualization.ComboChart( document.getElementById( dyamicID ) );
        chart.draw( data, options );
        google.charts.setOnLoadCallback( drawChart );



      } );
    },
    dataType: 'json'
  } );

  //ajax


}


//getLeadCallGraphFilter
// getLeadLMGraphFilter
//getLeadStagesGraphFilter();

function getLeadStagesGraphFilter()
{

  var salesPerson = $( '#salesPerson' ).val();
  var txtStages = $( '#txtStages' ).val();
  var formData = {
    'salesPerson': salesPerson,
    'txtStages': txtStages,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  //ajax
  $.ajax( {
    url: BASE_URL + '/getFilterLeadStagesCompleted',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      $.each( res, function ( key, value )
      {

        console.log( value.step_name );

        var data = google.visualization.arrayToDataTable( value.step_data );
        var options = {
          title: value.step_name + " Total:" + value.step_totalCount,

          seriesType: 'bars',
          series: { 1: { type: 'line' } },
          colors: [ '#008080', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6' ]
        };
        var dyamicID = value.step_code;
        var chart = new google.visualization.ComboChart( document.getElementById( dyamicID ) );
        chart.draw( data, options );
        google.charts.setOnLoadCallback( drawChart );



      } );
    },
    dataType: 'json'
  } );

  //ajax


}


function showUserwiseDailyStageCopleted( user_id )
{

  var formData = {
    'user_id': user_id,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };

  $.ajax( {
    url: BASE_URL + '/getFilteruserWiseStageCompleted',
    type: 'POST',
    data: formData,
    success: function ( res )
    {

      $.each( res, function ( key, value )
      {

        console.log( value.step_name );

        var data = google.visualization.arrayToDataTable( value.step_data );
        var options = {
          title: value.step_name + " Total:" + value.step_totalCount,

          seriesType: 'bars',
          series: { 1: { type: 'line' } },
          colors: [ '#008080', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6' ]
        };
        var dyamicID = value.step_code;
        var chart = new google.visualization.ComboChart( document.getElementById( dyamicID ) );
        chart.draw( data, options );
        google.charts.setOnLoadCallback( drawChart );



      } );
    },
    dataType: 'json'
  } );


}


$( "#inputGroupFile01" ).change( function ( event )
{
  RecurFadeIn();
  readURL( this );
} );
$( "#inputGroupFile01" ).on( 'click', function ( event )
{
  RecurFadeIn();
} );




function readURL( input )
{
  if ( input.files && input.files[ 0 ] )
  {
    var reader = new FileReader();
    var filename = $( "#inputGroupFile01" ).val();
    filename = filename.substring( filename.lastIndexOf( '\\' ) + 1 );
    reader.onload = function ( e )
    {
      debugger;


      $( '#blah' ).attr( 'src', e.target.result );
      $( '#blah' ).hide();
      $( '#blah' ).fadeIn( 500 );
      $( '.custom-file-label' ).text( filename );
    }
    reader.readAsDataURL( input.files[ 0 ] );
  }
  $( ".alert" ).removeClass( "loading" ).hide();
}
function RecurFadeIn()
{
  console.log( 'ran' );
  FadeInAlert( "Wait for it..." );
}
function FadeInAlert( text )
{
  $( ".alert" ).show();
  $( ".alert" ).text( text ).addClass( "loading" );
}


//ajdatalist




var DatatablesSearchOptionsAdvancedSearchDataFilterStageCompleted = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {

      var a;
      a = $( "#m_table_ListOfStageCompletedFilter" ).DataTable( {
        responsive: !0,

        lengthMenu: [ 5, 10, 25, 50 ],
        pageLength: 10,
        language: {
          lengthMenu: "Display _MENU_"
        },
        searchDelay: 500,
        processing: !0,
        serverSide: !0,
        ajax: {

          url: BASE_URL + '/getOrderListOfstageCompleted',
          type: "POST",
          data: {
            columnsDef: [
              "RecordID",
              "order_id",
              "brand_name",
              "form_id",
              "item_name",
              "curr_order_statge",
              "created_by",
              "created_on",
              "completed_by",
              "curr_order_statge", ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
          }
        },
        columns: [ {
          data: "RecordID"
        }, {
          data: "order_id"
        }, {
          data: "brand_name"
        }, {
          data: "item_name"
        }, {
          data: "created_by"
        }, {
          data: "created_on"
        }, {
          data: "completed_by"
        }, {
          data: "curr_order_statge"
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
            return '\n                        <span class="dropdown">\n                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n                              <i class="la la-ellipsis-h"></i>\n                            </a>\n                            <div class="dropdown-menu dropdown-menu-right">\n                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\n                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\n                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\n                            </div>\n                        </span>\n                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n                          <i class="la la-edit"></i>\n                        </a>'
          }
        },
        {
          targets: -2,
          title: "Current Stages",
          orderable: !1,
          render: function ( a, t, e, n )
          {
            return `<a href="javascript::void(0)" style="text-decoration:none" onclick="showmeMyStatgeCompletedStage(${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;


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
  DatatablesSearchOptionsAdvancedSearchDataFilterStageCompleted.init()
} );

//ajdatalist


// showmeMyStatge
function showmeMyStatgeCompletedStage( form_id )
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
// showmeMyStatge


// showFilterStageCompleted
function showFilterStageCompleted()
{



  //var courier_details= $( "#filterFor option:selected" ).val();
  var filterFor = $( 'select[name="filterFor"]' ).find( ":selected" ).val();
  var stageName = $( 'select[name="stageName"]' ).find( ":selected" ).val();

  //alert(filterFor);

  $( "#Am_table_ListOfStageCompletedFilter" ).dataTable().fnDestroy();


  var a;
  a = $( "#Am_table_ListOfStageCompletedFilter" ).DataTable( {
    responsive: !0,

    lengthMenu: [ 5, 10, 25, 50 ],
    pageLength: 10,
    language: {
      lengthMenu: "Display _MENU_"
    },
    searchDelay: 500,
    processing: !0,
    serverSide: !0,
    ajax: {

      url: BASE_URL + '/getOrderListOfstageCompleted',
      type: "POST",
      data: {
        columnsDef: [
          "RecordID",
          "order_id",
          "brand_name",
          "form_id",
          "item_name",
          "curr_order_statge",
          "created_by",
          "created_on",
          "completed_by",
          "curr_order_statge", ],
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'filterFor': filterFor,
        'stageName': stageName,

      }
    },
    columns: [ {
      data: "RecordID"
    }, {
      data: "order_id"
    }, {
      data: "brand_name"
    }, {
      data: "item_name"
    }, {
      data: "created_by"
    }, {
      data: "created_on"
    }, {
      data: "completed_by"
    }, {
      data: "curr_order_statge"
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
        return '\n                        <span class="dropdown">\n                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n                              <i class="la la-ellipsis-h"></i>\n                            </a>\n                            <div class="dropdown-menu dropdown-menu-right">\n                                <a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\n                                <a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\n                                <a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\n                            </div>\n                        </span>\n                        <a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n                          <i class="la la-edit"></i>\n                        </a>'
      }
    },
    {
      targets: -2,
      title: "Current Stages",
      orderable: !1,
      render: function ( a, t, e, n )
      {
        return `<a href="javascript::void(0)" style="text-decoration:none" onclick="showmeMyStatgeCompletedStage(${ e.form_id })"><h6 class="m--font-brand" title='View Details'>${ e.curr_order_statge }</h6></a>`;


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
// showFilterStageCompleted


var DatatablesSearchOptionsAdvancedSearchPOCLISt = function ()
{
  $.fn.dataTable.Api.register( "column().title()", function ()
  {
    return $( this.header() ).text().trim()
  } );
  return {
    init: function ()
    {
      var a;
      a = $( "#m_table_1_POC_LIST" ).DataTable( {
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

          url: BASE_URL + '/getPOCDataAll',
          type: "POST",
          data: {
            columnsDef: [
              "RecordID",
              "type",
              "size",
              "name",
              "img_1",
              "img_2",
              "img_3",
            ],
            '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),


          }
        },
        columns: [ {
          data: "RecordID"
        },
        {
          data: "img_1"
        }, {
          data: "img_2"
        }, {
          data: "img_3"
        },
        {
          data: ""
        },
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
              var edit_POC_ = BASE_URL + '/edit-poc/' + e.RecordID;

              return `<a href="${ edit_POC_ }" class="btn btn-primary m-btn m-btn--icon btn-sm m-btn--icon-only">
                      <i class="la la-edit "></i>
                    </a>`;
            }
          }, {
            targets: 1,
            render: function ( a, t, e, n )
            {
              var img_1 = BASE_URL + "/" + e.img_1;

              return `<div class="m-widget3__user-img">
                      <img class="m-widget3__img" src="${ img_1 }" alt="" width="100">
                    </div>`;
            }
          },
          {
            targets: 2,
            render: function ( a, t, e, n )
            {
              var img_1 = BASE_URL + "/" + e.img_2;

              return `<div class="m-widget3__user-img">
                    <img class="m-widget3__img" src="${ img_1 }" alt="" width="100">
                  </div>`;
            }
          },
          {
            targets: 3,
            render: function ( a, t, e, n )
            {
              var img_1 = BASE_URL + "/" + e.img_3;

              return `<div class="m-widget3__user-img" style="border:1px solid #035496">
                  <img class="m-widget3__img" src="${ img_1 }" alt="" width="100">
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
jQuery( document ).ready( function ()
{
  DatatablesSearchOptionsAdvancedSearchPOCLISt.init()
} );





$( '#btnSavePackOptCata' ).click( function ()
{
  var type = $( '#txtPOCType' ).val();
  var size = $( '#txtPOCSize' ).val();
  var name = $( '#txtPOCName' ).val();
  // ajax call
  var formData = {
    'type': type,
    'size': size,
    'name': name,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/saveOPCDataOnly',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      //console.log(res);
      toasterOptions();
      toastr.success( 'Saved successfully!', 'Packaging Option catalog' )
      setTimeout( function ()
      {
        //window.location.href = BASE_URL+'/orders'
        //location.reload();


      }, 500 );


    }
  } );

  // ajax call

} );


function showMeSlide( slideID )
{

  // ajax call
  var formData = {
    'slideid': slideID,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getPOCImges',
    type: 'POST',
    data: formData,
    success: function ( res )
    {
      $( '.ajslideMe' ).html( "" );

      var imgURL_1 = BASE_URL + "/local/public/uploads/photos/" + res.img_1;
      var imgURL_2 = BASE_URL + "/local/public/uploads/photos/" + res.img_2;
      var imgURL_3 = BASE_URL + "/local/public/uploads/photos/" + res.img_3;
      $( '.ajslideMe' ).append( ` <div class="carousel-item active">
   <img class="d-block w-100" src="${ imgURL_1 }" alt="First slide">
 </div>
 <div class="carousel-item">
   <img class="d-block w-100" src="${ imgURL_2 }" alt="Second slide">
 </div>
 <div class="carousel-item">
   <img class="d-block w-100" src="${ imgURL_3 }" alt="Third slide">
 </div>`);
      $( '#m_modal_4_SlideShow' ).modal( 'show' );
      $( '.carousel' ).carousel()


    },
    dataType: 'json'
  } );

  // ajax call



}

$( '#m_reset_POC' ).click( function ()
{

  // $('#poc_type option:selected').val("");
  // $('#poc_material option:selected').val("");
  // $('#poc_size option:selected').val("");
  // $('#poc_color option:selected').val("");
  // $('#poc_sape option:selected').val("");
  $( '#poc_name' ).val( "" );
  // $('#poc_code').val("");
  $( `#poc_type option[value='']` ).prop( 'selected', true );
  $( `#poc_material option[value='']` ).prop( 'selected', true );
  $( `#poc_size option[value='']` ).prop( 'selected', true );
  $( `#poc_color option[value='']` ).prop( 'selected', true );
  $( `#poc_sape option[value='']` ).prop( 'selected', true );


} );

$( '#m_search_POC' ).click( function ()
{
  var poc_type = $( '#poc_type option:selected' ).val();
  var poc_material = $( '#poc_material option:selected' ).val();
  var poc_size = $( '#poc_size option:selected' ).val();
  var poc_color = $( '#txtPOCColorN option:selected' ).val();
  var poc_sape = $( '#txtPOCSapeN option:selected' ).val();
  var poc_name = $( '#txtPOCN' ).val();
  var poc_code = $( '#poc_code' ).val();
  $( '.ajrowFilter' ).html( "" );

  //ajax call
  var formData = {
    'poc_type': poc_type,
    'poc_material': poc_material,
    'poc_size': poc_size,
    'poc_color': poc_color,
    'poc_sape': poc_sape,
    'poc_name': poc_name,
    'poc_code': poc_code,
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
  };
  $.ajax( {
    url: BASE_URL + '/getPOCFilter',
    type: 'POST',
    data: formData,
    success: function ( res )
    {




      $.each( res, function ( index, row )
      {
        var img_url = BASE_URL + '/local/public/uploads/photos/' + row.img_1;
        $( '.ajrowFilter' ).append( `<div class="col-md-3">
          <!--begin:: Widgets/Blog-->
          <div class="m-portlet m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded-force">
            <div class="m-portlet__head m-portlet__head--fit">
              <div class="m-portlet__head-caption">
                <div class="m-portlet__head-action">

                </div>
              </div>
            </div>

            <div class="m-portlet__body">
              <div class="m-widget19">
              <a href="javascript::void(0)" title="${ row.poc_name }" onclick="showMeSlide(${ row.id })">
                <div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides" style="min-height-: 286px;border:1px solid #ccc">
                  <img src="${ img_url }" alt="" style="display: block;width: 100%;height: 80%">

                </div>
                </a>


                <div class="m-widget19__content">
                   <!-- data -->
                    <div class="m-widget29">
                      <div class="m-widget19__info" style="margin-top:10px">
                            <span class="m-widget19__username">

                               ${ row.poc_code }
                            </span><br>
                            <span class="m-widget19__time" title="${ row.poc_name }">
                            ${ row.poc_type },${ row.poc_material },<br>
                            ${ row.poc_size },${ row.poc_color },
                            ${ row.poc_sape }
                            </span>
                          </div>
                          <a href="javascript::void(0)" id="${ row.poc_code }-${ row.poc_name }"  class="btnSelectBOM btn btn-primary btn-sm m-btn  m-btn m-btn--icon">
															<span>
																<i class="fa flaticon-cart"></i>
																<span>Add to Order</span>
															</span>
														</a>


                    </div>
                   <!-- data -->
                </div>

              </div>
            </div>
          </div>
        </div>`);
      } );

      $( '.btnSelectBOM' ).click( function ()
      {

        var bomCode = $( this ).attr( 'id' );


        var rowid = $( '#txtPOCBOMID' ).val();
        $( `input[name$='[${ rowid }][bom]']` ).val( bomCode );
        $( '#m_modal_4_ChoosePOC' ).modal( 'hide' );
        $( '#m_modal_4_SlideShow' ).modal( 'hide' );

      } );



    },
    dataType: 'json'
  } );

  //ajax call





} );



//scroll download
var busy = false;
var limit = 15
var offset = 0;
function displayRecords( lim, off )
{
  jQuery.ajax( {
    type: "GET",
    async: false,
    url: BASE_URL + '/getPOCInfinite/',
    data: "limit=" + lim + "&offset=" + off,
    cache: false,
    beforeSend: function ()
    {
      $( "#loader_message" ).html( "" ).hide();
      $( '#loader_image' ).show();
    },
    success: function ( html )
    {
      $( ".ajrowFilter" ).append( html );
      $( '#loader_image' ).hide();
      if ( html == "" )
      {
        $( "#loader_message" ).html( '<button class="btn btn-default" type="button">No more records.</button>' ).show()
      } else
      {
        $( "#loader_message" ).html( '<button class="btn btn-default" type="button">Loading please wait...</button>' ).show();
      }
      window.busy = false;
    }
  } );
}
$( document ).ready( function ()
{
  // start to load the first set of data
  if ( busy == false )
  {
    busy = true;
    // start to load the first set of data
    displayRecords( limit, offset );
  }
  $( window ).scroll( function ()
  {
    // make sure u give the container id of the data to be loaded in.
    if ( $( window ).scrollTop() + $( window ).height() > $( "#results" ).height() && !busy )
    {

      busy = true;
      offset = limit + offset;
      // this is optional just to delay the loading of data
      setTimeout( function () { displayRecords( limit, offset ); }, 500 );
      // you can remove the above code and can use directly this function
      //displayRecords(limit, offset);
    }
  } );
} );


//scroll download



function deletePOC( rowid )
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
        url: BASE_URL + "/deletePOC",
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
            swal( "Deleted!", "Your POC has been deleted.", "success" ).then( function ( eyz )
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

$( '.ajPICPOC' ).click( function ()
{

  var nameVal = $( this ).attr( 'name' );

  var subStr = nameVal.match( "qc(.*)" );
  var x = subStr[ 1 ].split( '[ad' );
  var y = x[ 0 ].split( '[' );
  z = y[ 1 ].split( ']' );
  rowid = z[ 0 ];

  var BOMVal = $( `input[name$='[${ rowid }][bom]']` ).val();

  $( '#txtPOCBOMID' ).val( rowid );
  $( '#m_modal_4_ChoosePOC' ).modal( 'show' );





} );

$( '.btnSelectBOM' ).click( function ()
{
  var bomCode = $( this ).attr( 'id' );
  var rowid = $( '#txtPOCBOMID' ).val();
  $( `input[name$='[${ rowid }][bom]']` ).val( bomCode );
  $( '#m_modal_4_ChoosePOC' ).modal( 'hide' );
  $( '#m_modal_4_SlideShow' ).modal( 'hide' );

} );





//pincode
$( '.ajrow' ).hide();
$( '.pincode' ).keyup( function ()
{
  if ( $( this ).val().length == 6 )
  {
    var formData = {
      'pincode': $( this ).val(),
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' )

    };
    $.ajax( {
      url: BASE_URL + '/getLocation',
      type: 'POST',
      data: formData,
      success: function ( res )
      {
        console.log( res.data );
        if ( res.status == 1 )
        {
          $( "input[name='loccity']" ).val( res.data.District );
          $( "input[name='locstate']" ).val( res.data.State );
          // $("input[name='loccountry']").val(res.data.Country);
          $( '.ajrow' ).show( 'slow' );
        } else
        {
          $( "input[name='loccity']" ).val( "" );
          $( "input[name='locstate']" ).val( "" );
          $( "input[name='loccountry']" ).val( "" );
          $( '.ajrow' ).hide( 'slow' );
        }

      }, dataType: 'json'
    } );
  }


} );

//pincode
