

  // Graph :2 order value and payment Recived : Admin 

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

    Highcharts.chart('containerA', {

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
//G2===========================================================



//G1.Admin Payment Recived  Graph : this show all payment Recived graph approved by admin

     //ajax call
     var formData = {
        '_token':$('meta[name="csrf-token"]').attr('content'),
        'daysCount':30
        };
        var jsonData = $.ajax({
        url: BASE_URL+'/getHighcartPaymentRecievedMonthly',
        dataType: "json",
        type: "POST",
        data: formData,
        async: false
        }).responseJSON;
       
        //ajax call


    Highcharts.chart('containerB', {
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
          text: 'Payment Recieved Graph'
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
          name: 'Payment Recieved',
          data: jsonData.monthlyValue
        }]
      });
//G1.=============================


if(UID!=1 || UID!=90){

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
         text: 'Payment Recieved Graph'
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
         name: 'Payment Recieved',
         data: jsonData.monthlyValue
       }]
     });

}

  
    
// G3:admin verifed lead grahg


  //ajax call 
  var formData = {
    '_token':$('meta[name="csrf-token"]').attr('content'),
    'daysCount':30
    };
    var jsonData = $.ajax({
    url: BASE_URL+'/getHighcartLeadVerifedThisMonth',
    dataType: "json",
    type: "POST",
    data: formData,
    async: false
    }).responseJSON;
   //ajax call
Highcharts.chart('containerLverified', {
    chart: {
      type: 'column',
      options3d: {
        enabled: false,
        alpha: 10,
        beta: 25,
        depth: 70
      }
    },
    title: {
      text: 'Lead Verified Graph'
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
      name: 'Lead Verified Date',
      data: jsonData.monthlyValue
    }]
  });
// G3:admin ====================================

//lead claim graph
  // containerLverified

  //ajax call
  alert(45454);
  var formData = {
    '_token':$('meta[name="csrf-token"]').attr('content'),
    'daysCount':30
    };
    var jsonData = $.ajax({
    url: BASE_URL+'/getHighcartLeadClaimThisMonth',
    dataType: "json",
    type: "POST",
    data: formData,
    async: false
    }).responseJSON;
   
    //ajax call
Highcharts.chart('containerLClaim', {
    chart: {
      type: 'column',
      options3d: {
        enabled: false,
        alpha: 10,
        beta: 25,
        depth: 70
      }
    },
    title: {
      text: 'Lead Claim/Assigned date wise  Graph'
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
      name: 'Lead Claim /Assigned Date',
      data: jsonData.monthlyValue
    }]
  });
  




//lead claim graph
