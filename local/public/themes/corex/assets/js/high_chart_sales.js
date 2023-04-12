



   //ajax call
   var formData = {
    '_token':$('meta[name="csrf-token"]').attr('content'),
    'daysCount':30
    };
    var jsonData = $.ajax({
    url: BASE_URL+'/getHighcartOrderValuePaymentRecieved',
    dataType: "json",
    type: "POST",
    data: formData,
    async: false
    }).responseJSON;
   
    //ajax call

Highcharts.chart('containerAD', {

    chart: {
        type: 'column'
    },

    title: {
        text: 'Total Order Values This month'
    },

    xAxis: {
        // categories: ['Suraj', 'Sahil', 'Azad']
        categories: jsonData.persons
    },

    yAxis: {
        allowDecimals: false,
        min: 0,
        title: {
            text: 'Order Values /Payment Recieved'
        }
    },

    tooltip: {
        pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
        shared: true
    },

    plotOptions: {
        column: {
            stacking: 'normal'
        }
    },

    series: [ {
        name: 'Payment Recieved',
        data: jsonData.paymentRecieved,
        
    },
    {
        name: 'Order Value',
        data: jsonData.OrderValue,
       
    }
    
]
});


      //ajax call
      var formData = {
         '_token':$('meta[name="csrf-token"]').attr('content'),
         'daysCount':30
         };
         var jsonData = $.ajax({
         url: BASE_URL+'/getHighcartPaymentRecievedMonthlybyUser',
         dataType: "json",
         type: "POST",
         data: formData,
         async: false
         }).responseJSON;
        
         //ajax call
  
  
     Highcharts.chart('containerC', {
         chart: {
           type: 'column',
           options3d: {
             enabled: true,
             alpha: 10,
             beta: 25,
             depth: 70
           }
         },
         title: {
           text: 'Payment Recieved Graph Sales'
         },
         subtitle: {
           text: '---------------------------------------------------'
         },
         plotOptions: {
           column: {
             depth: 25
           }
         },
         xAxis: {
           categories:jsonData.MonthName,
           labels: {
             skew3d: false,
             style: {
               fontSize: '16px'
             }
           }
         },
         yAxis: {
           title: {
             text: null
           }
         },
         series: [{
           name: 'Payment Received',
           data: jsonData.monthlyValue
         }]
       });
  

      //  -------------------containerC_INCData

      //ajax call
      var formData = {
        '_token':$('meta[name="csrf-token"]').attr('content'),
        'daysCount':30
        };
        var jsonData = $.ajax({
        url: BASE_URL+'/getHighcartIncentiveValueMonthlybyUser',
        dataType: "json",
        type: "POST",
        data: formData,
        async: false
        }).responseJSON;
       
        //ajax call

      Highcharts.chart('containerC_INCData', {
        chart: {
          type: 'column',
          options3d: {
            enabled: true,
            alpha: 10,
            beta: 25,
            depth: 70
          }
        },
        title: {
          text: 'Incentive  Graph Sales Person'
        },
        subtitle: {
          text: '---------------------------------------------------'
        },
        plotOptions: {
          column: {
            depth: 25
          }
        },
        colors: [   
           '#ff5733 '
       ],
        xAxis: {
          categories:jsonData.MonthName,
          labels: {
            skew3d: false,
            style: {
              fontSize: '16px'
            }
          }
        },
        yAxis: {
          title: {
            text: null
          }
        },
        series: [{
          name: 'Incentive Value',
          data: jsonData.monthlyValue
        }]
      });
      //  -------------------containerC_INCData
  
  
