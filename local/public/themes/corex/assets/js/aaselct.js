

// showOrderItemTechDataSelect

//showSampleItemTechDataSelectUI
$( "select.showSampleItemTechDataSelectUI" ).change( function ()
{
  var SID = $( this ).children( "option:selected" ).val();

  // ajax
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
      $( '.showSampleItemTechDataUI' ).html( '' );
      $( '#btnSampleTechSubmit' ).removeAttr( "disabled" );
      $.each( res.data, function ( index, value )
      {
        $( '.showSampleItemTechDataUI' ).append( `<div class="m-checkbox-list">
          <label class="m-checkbox m-checkbox--square">
            <input type="checkbox" name="sample_by_part_id[]" value="${ value.sample_id }"> ${ value.sample_itemname }
            <input type="hidden" name="sample_by_part_idN[]" value="${ value.sample_itemname }"> ${ value.sample_itemname }
            <span></span>
          </label>
        </div>`);
      } );


    },
    dataType: "json"
  } );
  // ajax

} );

//showSampleItemTechDataSelectUI
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
        <input type="hidden" name="sample_by_part_idN[]" value="" > 
        <span></span>
      </label>
    </div>`);
    $( '#btnSampleTechSubmit' ).removeAttr( "disabled" );

  } else
  {
    // ajax
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
        $( '.showSampleItemTechData' ).html( '' );
        $( '#btnSampleTechSubmit' ).removeAttr( "disabled" );
        $.each( res.data, function ( index, value )
        {
          $( '.showSampleItemTechData' ).append( `<div class="m-checkbox-list">
          <label class="m-checkbox m-checkbox--square">
            <input type="checkbox" name="sample_by_part_id[]" value="${ value.sample_id }@@${ value.sample_itemname }"> ${ value.sample_itemname }
            <input type="hidden" name="sample_by_part_idN[]" value="${ value.sample_itemname }"> ${ value.sample_itemname }
            <span></span>
          </label>
        </div>`);
        } );


      },
      dataType: "json"
    } );
    // ajax
  }



} );
  //showSampleItemTechDataSelect