







if ( $( location ).attr( 'href' ) === BASE_URL + "/claim-lead-graph" )
{

  //get sales team lead claim report 
  //Lead Manager Lead Verified 


  //ajax call
  var formData = {
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
    'daysCount': 30
  };
  var jsonData = $.ajax( {
    url: BASE_URL + '/getHighcartLeadClaimBySalesTeam',
    dataType: "json",
    type: "POST",
    data: formData,
    async: false
  } ).responseJSON;

  //ajax call

  Highcharts.chart( 'containerLCSalesTeam', {

    chart: {
      type: 'column'
    },

    title: {
      text: 'Total Lead Claim /Assigned by  Team of  last 30 days '
    },

    xAxis: {
      // categories: ['Suraj', 'Sahil', 'Azad']
      // categories: jsonData.persons,
      type: 'category',
      labels: {
        animate: true
      }
    },
    legend: {
      enabled: true
    },

    yAxis: {
      allowDecimals: false,
      min: 0,
      title: {
        text: 'Lead Count'
      }
    },

    tooltip: {
      pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> <br/>',
      shared: true
    },



    series: [ {

      dataSorting: {
        enabled: true,
        sortKey: 'y'
      },
      dataLabels: {
        enabled: true,
        format: '{y:,.0f}',

      },
      name: 'Lead Claim',
      data: jsonData.pLeadClaimValue

    },


    ]
  } );

  //containerLMVC_NVC
  var formDataAB = {
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
    'daysCount': 30
  };
  var jsonDataAB = $.ajax( {
    url: BASE_URL + '/getHighcartLeadNEWVerifedClaimThisMonthbyUser',
    dataType: "json",
    type: "POST",
    data: formDataAB,
    async: false
  } ).responseJSON;

  Highcharts.chart( 'containerLMVC_NVC', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'Monthly New Lead /Verified/Claim Graph'
    },
    subtitle: {
      text: 'Source: Bo ERP'
    },
    xAxis: {
      categories: jsonDataAB.MonthName,
    },
    yAxis: {
      title: {
        text: 'Lead'
      }
    },
    plotOptions: {
      line: {
        dataLabels: {
          enabled: true
        },
        enableMouseTracking: false
      }
    },
    series: [ {
      name: 'NEW',
      data: jsonDataAB.monthlyValue1NEW
    }, {
      name: 'Verified',
      data: jsonDataAB.monthlyValue2Verified
    },
    {
      name: 'Claim',
      data: jsonDataAB.monthlyValue2Claim
    },
    {
      name: 'Duplicate',
      data: jsonDataAB.monthlyValue2Duplocate
    },
    {
      name: 'Phone pickup',
      data: jsonDataAB.monthlyValue2PhonePickup
    }
    ]
  } );
  //=======================
  var formDataAB = {
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
    'daysCount': 30
  };
  var jsonDataAB = $.ajax( {
    url: BASE_URL + '/getHighcartLeadClaimThisMonthbyUser',
    dataType: "json",
    type: "POST",
    data: formDataAB,
    async: false
  } ).responseJSON;

  Highcharts.chart( 'containerLMVCL', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'Monthly Lead Claim'
    },
    subtitle: {
      text: 'Source: Bo ERP'
    },
    xAxis: {
      categories: jsonDataAB.MonthName,
    },
    yAxis: {
      title: {
        text: 'Lead'
      }
    },
    plotOptions: {
      line: {
        dataLabels: {
          enabled: true
        },
        enableMouseTracking: false
      }
    },
    series: [ {
      name: 'Roby Gupta',
      data: jsonDataAB.monthlyValue1
    }, {
      name: 'Shreya',
      data: jsonDataAB.monthlyValue2
    } ]
  } );


  //containerLMVC_NVC

  //get sales team lead claim report 

  //Lead Manager Lead Verified 
  var formDataAB = {
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
    'daysCount': 30
  };
  var jsonDataAB = $.ajax( {
    url: BASE_URL + '/getHighcartLeadVerifedThisMonthbyUser',
    dataType: "json",
    type: "POST",
    data: formDataAB,
    async: false
  } ).responseJSON;

  Highcharts.chart( 'containerLMVC', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'Monthly Lead Verification'
    },
    subtitle: {
      text: 'Source: Bo ERP'
    },
    xAxis: {
      categories: jsonDataAB.MonthName,
    },
    yAxis: {
      title: {
        text: 'Lead'
      }
    },
    plotOptions: {
      line: {
        dataLabels: {
          enabled: true
        },
        enableMouseTracking: false
      }
    },
    series: [ {
      name: 'Roby Gupta',
      data: jsonDataAB.monthlyValue1
    }, {
      name: 'Shreya',
      data: jsonDataAB.monthlyValue2
    } ]
  } );
  //=======================
  var formDataAB = {
    '_token': $( 'meta[name="csrf-token"]' ).attr( 'content' ),
    'daysCount': 30
  };
  var jsonDataAB = $.ajax( {
    url: BASE_URL + '/getHighcartLeadClaimThisMonthbyUser',
    dataType: "json",
    type: "POST",
    data: formDataAB,
    async: false
  } ).responseJSON;

  Highcharts.chart( 'containerLMVCL', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'Monthly Lead Claim'
    },
    subtitle: {
      text: 'Source: Bo ERP'
    },
    xAxis: {
      categories: jsonDataAB.MonthName,
    },
    yAxis: {
      title: {
        text: 'Lead'
      }
    },
    plotOptions: {
      line: {
        dataLabels: {
          enabled: true
        },
        enableMouseTracking: false
      }
    },
    series: [ {
      name: 'Roby Gupta',
      data: jsonDataAB.monthlyValue1
    }, {
      name: 'Shreya',
      data: jsonDataAB.monthlyValue2
    } ]
  } );


  //Lead Manager Lead Verified 

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
      text: 'Lead Claim / Assigned  Graph '
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
      name: 'Lead Claim /Assigned  Date',
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

