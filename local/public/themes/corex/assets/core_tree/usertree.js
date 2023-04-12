



    // Another approach, same result
    // JSON approach

      //ajax request
      var formData = {
         'UUID':$('meta[name="UUID"]').attr('content'),      
        '_token':$('meta[name="csrf-token"]').attr('content')
        
      };
 
      $.ajax({
       url: BASE_URL+'/getUserTree',
       type: 'POST',
       data: formData,
       success: function(data) {
            //-----------------------
            var chart_config = {
                chart: {
                    container: "#basic-example",
        
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
       }  ,
       dataType : 'json'
     });
 
      //ajax request


     

    


   