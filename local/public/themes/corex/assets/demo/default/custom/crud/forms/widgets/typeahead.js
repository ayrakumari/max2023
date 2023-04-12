// Class definition
var KTTypeahead = function() {
    
   

   

    

    var demo4 = function() {
        // var bestPictures = new Bloodhound({
        //     datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
        //     queryTokenizer: Bloodhound.tokenizers.whitespace,
        //     prefetch: 'https://preview.keenthemes.com/metronic/theme/html/tools/preview/api/?file=typeahead/movies.json'
        // });
        // console.log(bestPictures);

        // $('#kt_typeahead_4').typeahead(null, {
        //     name: 'best-pictures',
        //     display: 'value',
        //     source: bestPictures,
        //     templates: {
        //         empty: [
        //             '<div class=\"empty-message\" style=\"padding: 10px 15px; text-align: center;\">',
        //             'Unable to find!',
        //             '</div>'
        //         ].join('\n'),
        //         suggestion: Handlebars.compile('<div><strong>{{value}}</strong> â€“ {{year}}</div>')
        //     }
        // });

        // Instantiate the Bloodhound suggestion engine


  var restaurants = new Bloodhound({
    datumTokenizer: function(datum) {
        return Bloodhound.tokenizers.whitespace(datum.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: { 
        url: "/",
        transform: function(response) {
                return $.map(response, function(restaurant) {
                    return { 
                         value: restaurant.name,
                         id: restaurant.id ,
                         price_1: restaurant.price_1 
                    };
                });
            } 
    },
    remote: {
        wildcard: '%QUERY%',
        url: BASE_URL+"/api/getRMData/%QUERY%",
            transform: function(response) {
                return $.map(response, function(restaurant) {
                    return { 
                        value: restaurant.name,
                        id: restaurant.id,
                        price_1: restaurant.price_1 
                     };
                });
            }
    }
});

// $('#kt_typeahead_4').typeahead({
//     hint: false,
//     highlight: true,
//     minLength: 2,
//     limit: 50
// },
// {
//     name: 'Restaurants',
//     display: 'value',
//     source: restaurants,
//     templates: {
//             header: '<h4 class="dropdown">Restaurants</h4>'
//     }   
// }
// );

// Instantiate the Typeahead UI
$('#kt_typeahead_4').typeahead({
    hint: true,
    highlight: true,
    minLength: 1
  }, {
    limit: 50, // This controls the number of suggestions displayed
    displayKey: 'value',
    source: restaurants
   });

  
    }

   

    return {
        // public functions
        init: function() {
          
           demo4();           
        }
    };
}();

function extractFloat(text) {
    const match = text.match(/\d+((\.|,)\d+)?/)
    return match && match[0]
  }



jQuery(document).ready(function() {
    KTTypeahead.init();
    $('#kt_typeahead_4').typeahead('val','');
    
   $("input[name=txtDose]").val("");
  $("input[name=txtIPrice]").val("");
  $('#kt_typeahead_4').focus(function(){
      
      $('#txtRMID').val("");
      $('#txtRMTEXT').val("");
  });

    $('#kt_typeahead_4').on('typeahead:selected', function(event, datum) {
        //  console.log(event);
        var price=extractFloat(datum.price_1);    
        $('#txtRSize').html('1Kg');   
        $('#txtRPrice').html("Rs"+parseFloat(price));   
        $('#m_inputmask_6').focus().val("");
        

         console.log(datum);
         $('#txtRMID').val(datum.id);
         $('#txtRMTEXT').val(datum.value);
         $("input[name=txtIPrice]").val(parseFloat(price));
      });

});