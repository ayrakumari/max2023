var windowLoadAjax = {
  initA: function ()
  {
    //G1.Admin Payment Recived  Graph : this show all payment Recived graph approved by admin

    //ajax call
    var formData = {
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
      'daysCount': 30
    };
    var jsonData = $.ajax( {
      url: BASE_URL + '/getHighcartPaymentRecievedMonthly',
      dataType: "json",
      type: "GET",
      data: formData,
      async: false
    } ).responseJSON;




    //ajax call



    Highcharts.chart( 'containerB', {
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
        text: 'Payment Received Monthly Graph  '
      },
      subtitle: {
        text: '---------------------------------------------------'
      },
      plotOptions: {
        column: {
          depth: 10
        }
      },
      xAxis: {
        categories: jsonData.MonthName,
        labels: {
          skew3d: false,
          style: {
            fontSize: '12px'
          }
        }
      },
      yAxis: {
        title: {
          text: null
        }
      },
      series: [ {
        name: 'Payment',
        data: jsonData.monthlyValue
      } ]
    } );
    //G1.=============================


  },
  initBulkOrder: function ()
  {
    //G1.Admin Payment Recived  Graph : this show all payment Recived graph approved by admin

    //ajax call
    var formData = {
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
      'daysCount': 30
    };
    var jsonData = $.ajax( {
      url: BASE_URL + '/getHighcartPaymentRecievedMonthly_BULKORDER',
      dataType: "json",
      type: "GET",
      data: formData,
      async: false
    } ).responseJSON;




    //ajax call



    Highcharts.chart( 'containerBulkOrder', {
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
        text: 'Order Values of Bulk Order'
      },
      subtitle: {
        text: '---------------------------------------------------'
      },
      plotOptions: {
        column: {
          depth: 10
        }
      },
      xAxis: {
        categories: jsonData.MonthName,
        labels: {
          skew3d: false,
          style: {
            fontSize: '12px'
          }
        }
      },
      yAxis: {
        title: {
          text: null
        }
      },
      series: [ {
        name: 'Payment',
        data: jsonData.monthlyValue
      } ]
    } );
    //G1.=============================


  },
  initPrivateOrder: function ()
  {
    //G1.Admin Payment Recived  Graph : this show all payment Recived graph approved by admin

    //ajax call
    var formData = {
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
      'daysCount': 30
    };
    var jsonData = $.ajax( {
      url: BASE_URL + '/getHighcartPaymentRecievedMonthly',
      dataType: "json",
      type: "GET",
      data: formData,
      async: false
    } ).responseJSON;




    //ajax call



    Highcharts.chart( 'containerPrivateOrder', {
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
        text: 'Order Values of Private Order'
      },
      subtitle: {
        text: '---------------------------------------------------'
      },
      plotOptions: {
        column: {
          depth: 10
        }
      },
      xAxis: {
        categories: jsonData.MonthName,
        labels: {
          skew3d: false,
          style: {
            fontSize: '12px'
          }
        }
      },
      yAxis: {
        title: {
          text: null
        }
      },
      series: [ {
        name: 'Payment',
        data: jsonData.monthlyValue
      } ]
    } );
    //G1.=============================


  },
  initB: function ()
  {
    //G1.Admin Payment Recived  Graph : this show all payment Recived graph approved by admin

    //ajax call
    var formData = {
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
      'daysCount': 30
    };


    var jsonDataOrder = $.ajax( {
      url: BASE_URL + '/getHighcartOrderPunchedMonthly',
      dataType: "json",
      type: "GET",
      data: formData,
      async: false
    } ).responseJSON;

    var colors = [];
    colors[0] = '#035496';
    colors[1] = '#C70039';

    //ajax call
    //containerTotalOrderMonthly
    Highcharts.chart( 'containerTotalOrderMonthly', {
      chart: {
        type: 'column',
        options3d: {
          enabled: false,
          alpha: 10,
          beta: 25,
          depth: 10
        }
      },
      title: {
        text: 'Orders Monthly Graph  '
      },
      colors: colors,
      subtitle: {
        text: '==========================================='
      },
      plotOptions: {
        column: {
          depth: 25
        },

      },
      xAxis: {
        categories: jsonDataOrder.MonthName,
        labels: {
          skew3d: false,
          style: {
            fontSize: '16px'
          }
        }
      },
      yAxis: {
        title: {
          text: null,
          color: '#035496'
        }
      },
      series: [ {
        name: 'Orders month wise',
        data: jsonDataOrder.monthlyValue
      } ]
    } );

    //containerTotalOrderMonthly



    //G1.=============================


  },
  initC: function ( day )
{
    //ajax call
    var formData = {
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
      'daysCount': day
    };
    var jsonData = $.ajax( {
      url: BASE_URL + '/getHighcartLast7daysCall',
      dataType: "json",
      type: "GET",
      data: formData,
      async: false
    } ).responseJSON;

    //ajax call

    Highcharts.chart( 'containerLast7DaysCall', {

      chart: {
        type: 'column'
      },

      title: {
        text: 'Last ' + day + ' Days Call Recieved/Average Call '
      },

      xAxis: {
        // categories: ['Suraj', 'Sahil', 'Azad']
        categories: jsonData.persons
      },

      yAxis: {
        allowDecimals: false,
        min: 0,
        title: {
          text: 'No of calls'
        }
      },

      tooltip: {
        pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b><br/>',
        shared: true
      },



      series: [ {
        name: 'Received Call',
        data: jsonData.paymentRecieved,

      },
      {
        name: 'Average Call',
        data: jsonData.OrderValue,

      }

      ]
    } );
    //ajax call

  },
  initD: function ( day )
{


    var formData = {
      '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
      'daysCount': day
    };
    var jsonData = $.ajax( {
      url: BASE_URL + '/getHighcartLast30daysTotalRecivedMissedCall',
      dataType: "json",
      type: "GET",
      data: formData,
      async: false
    } ).responseJSON;

    var colors = [];
                colors[0] = '#047e04';
                colors[1] = '#C70039';


    Highcharts.chart( 'containerLast7DaysCall', {
      chart: {
        type: 'column'
      },
      colors: colors,

      title: {
        text: 'Last ' + day + ' Days Total Recieved/Missed Call '
      },
      xAxis: {
        categories: jsonData.persons
      },
      yAxis: {
        min: 0,
        title: {
          text: 'Total Recieved /Missed Call'
        },
        stackLabels: {
          enabled: true,
          style: {
            fontWeight: 'bold',
            color: ( // theme
              Highcharts.defaultOptions.title.style &&
              Highcharts.defaultOptions.title.style.color
            ) || 'gray'
          }
        }
      },
      legend: {
        align: 'right',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor:
          Highcharts.defaultOptions.legend.backgroundColor || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
      },
      tooltip: {
        headerFormat: '<b>{point.x}</b><br/>',
        pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
      },
      plotOptions: {
        column: {
          stacking: 'normal',
          dataLabels: {
            enabled: true
          }
        }
      },
      series: [
        {
          name: 'Recieved Call',
          data: jsonData.paymentRecieved,
        }, {
          name: 'Missed Call',
          data: jsonData.OrderValue,

        }
      ]
    } );

  },
  initE: function ( day )
  {
  
  
      var formData = {
        '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
        'daysCount': day
      };
      var jsonData = $.ajax( {
        url: BASE_URL + '/getHighcartLast30daysTotalSamplesAdded',
        dataType: "json",
        type: "GET",
        data: formData,
        async: false
      } ).responseJSON;
  
      var colors = [];
                  colors[0] = '#035496';
                  colors[1] = '#00a0c7';
                  colors[2] = 'green';
  
  
      Highcharts.chart( 'containerLast7DaysCall', {
        chart: {
          type: 'column'
        },
        colors: colors,
  
        title: {
          text: 'Last ' + day + ' Days Total Samples Added '
        },
        xAxis: {
          categories: jsonData.persons
        },
        yAxis: {
          min: 0,
          title: {
            text: 'Total Sample Added '
          },
          stackLabels: {
            enabled: false,
            style: {
              fontWeight: 'bold',
              color: ( // theme
                Highcharts.defaultOptions.title.style &&
                Highcharts.defaultOptions.title.style.color
              ) || 'gray'
            }
          }
        },
        legend: {
          align: 'right',
          x: -30,
          verticalAlign: 'top',
          y: 25,
          floating: true,
          backgroundColor:
          Highcharts.defaultOptions.legend.backgroundColor || 'white',
          borderColor: '#CCC',
          borderWidth: 1,
          shadow: false
        },
        tooltip: {
          headerFormat: '<b>{point.x}</b><br/>',
          pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
        },
        plotOptions: {
          column: {
            stacking: 'normal',
            dataLabels: {
              enabled: true
            }
          }
        },
        series: [
          {
            name: 'Sample Added',
            data: jsonData.paymentRecieved,
          }
        ]
      } );
  
    },

}
containerPrivateOrder



jQuery( document ).ready( function ()
{
  windowLoadAjax.initA();
  windowLoadAjax.initB();
  windowLoadAjax.initBulkOrder();
  windowLoadAjax.initPrivateOrder();





} );

function btnShowChart( day )
{

  windowLoadAjax.initC( day );

}
function btnShowChartTotalCallReceived( day )
{
  windowLoadAjax.initD( day );
}
function btnShowChartTotalSampleAdded( day )
{
  windowLoadAjax.initE( day );
}







if ( $( location ).attr( 'href' ) === BASE_URL + "/claim-lead-graph" )
{

  // G3:admin verifed lead grahg
  var formDataA = {
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
    'daysCount': 30
  };
  var jsonDataA = $.ajax( {
    url: BASE_URL + '/getHighcartLeadClaimThisMonth',
    dataType: "json",
    type: "POST",
    data: formDataA,
    async: false
  } ).responseJSON;

  //ajax call
  Highcharts.chart( 'containerLClaim', {
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
      text: 'Lead Claim /Assigned Graph'
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
      categories: jsonDataA.MonthName,
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
    series: [ {
      name: 'Lead Claim/Assigned  Date',
      data: jsonDataA.monthlyValue
    } ]
  } );



  //ajax call 
  var formData = {
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
    'daysCount': 30
  };
  var jsonData = $.ajax( {
    url: BASE_URL + '/getHighcartLeadVerifedThisMonth',
    dataType: "json",
    type: "POST",
    data: formData,
    async: false
  } ).responseJSON;
  //ajax call
  Highcharts.chart( 'containerLverified', {
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
      categories: jsonData.MonthName,
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
    series: [ {
      name: 'Lead Verified Date',
      data: jsonData.monthlyValue
    } ]
  } );

}
if ( $( location ).attr( 'href' ) === BASE_URL + "/getLeadReports" )
{
  // lead monthwise 




  //  -------------------containerC_INCData

  //ajax call
  var formData = {
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
    'daysCount': 30
  };
  var jsonData = $.ajax( {
    url: BASE_URL + '/getHighcartFreshLeadRemainigValueMonthly',
    dataType: "json",
    type: "POST",
    data: formData,
    async: false
  } ).responseJSON;

  //ajax call

  Highcharts.chart( 'containerASD', {
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
      text: 'Fresh Lead Month Wise'
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
      '#035496 '
    ],
    xAxis: {
      categories: jsonData.MonthName,
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
    series: [ {
      name: 'Fresh Lead Values',
      data: jsonData.monthlyValue
    } ]
  } );
  //  -------------------containerC_INCData

  // containerASD_CallData


  //ajax call
  var formData = {
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
    'daysCount': 30
  };
  var jsonData = $.ajax( {
    url: BASE_URL + '/getHighcartRecievedMissedMonthwise',
    dataType: "json",
    type: "POST",
    data: formData,
    async: false
  } ).responseJSON;

  //ajax call

  Highcharts.chart( 'containerASD_CallData', {
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
      text: 'Call Recived /Missed call month wise'
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
      '#15db36',
      '#FF5733'
    ],
    xAxis: {
      categories: jsonData.MonthName,
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
    series: [ {
      name: 'received',
      data: jsonData.monthlyValue
    },
    {
      name: 'Missed',
      data: jsonData.monthlyMissed
    }
    ]
  } );

  // containerASD_CallData



  // lead monthwise 
}
//if($(location).attr('href')===BASE_URL+"/getChartReport"){


if ( $( location ).attr( 'href' ) === BASE_URL + "/getChartReport" )
{

  // G3:admin ====================================
  // Graph :2 order value and payment Recived : Admin 

  //ajax call
  var formData = {
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
    'daysCount': 30
  };
  var jsonData = $.ajax( {
    url: BASE_URL + '/getHighcartOrderValuePaymentRecieved',
    dataType: "json",
    type: "POST",
    data: formData,
    async: false
  } ).responseJSON;

  //ajax call

  Highcharts.chart( 'containerA', {

    chart: {
      type: 'column'
    },

    title: {
      text: 'Total Order Values This month '
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
  } );
  //G2===========================================================


  // G3:admin ====================================
  // Graph :2 order value and payment Recived : Admin 

  //ajax call
  var formData = {
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
    'daysCount': 30
  };
  var jsonData = $.ajax( {
    url: BASE_URL + '/getHighcartSampleAssigned',
    dataType: "json",
    type: "POST",
    data: formData,
    async: false
  } ).responseJSON;

  //ajax call

  Highcharts.chart( 'containerA_SAssigned', {

    chart: {
      type: 'column'
    },

    title: {
      text: 'Sample Assigned List '
    },

    xAxis: {
      // categories: ['Suraj', 'Sahil', 'Azad']
      categories: jsonData.persons
    },

    yAxis: {
      allowDecimals: false,
      min: 0,
      title: {
        text: 'No . of samples'
      }
    },

    tooltip: {
      // pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.0f}%)<br/>',
      shared: true
    },

    plotOptions: {
      column: {
        stacking: 'normal'
      }
    },

    series: [ {
      name: 'Samples',
      data: jsonData.paymentRecieved,

    },


    ]
  } );
  //G2===========================================================



}




