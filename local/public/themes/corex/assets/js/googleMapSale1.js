//drawChart_1(); //
//drawChart_2();
//drawChart_3();
//drawChart_4();
//drawChart_5();
//drawChart_6();

drawChart_7_S(); //sales
drawChart_8_S(); //sales

drawChart_7R_S(); //sales

drawChart_7R_SMonthly(); //sales

//month sied sales call cournt
function drawChart_7R_SMonthly(){
  google.charts.setOnLoadCallback(drawVisualization_613);

  function drawVisualization_613() {
      // Some raw data (not necessarily accurate)

      //ajax call
      var formData = {
      '_token':$('meta[name="csrf-token"]').attr('content'),
      };
      var jsonData = $.ajax({
      url: BASE_URL+'/getSalesAllCallRecievedMonth',
      dataType: "json",
      type: "POST",
      data: formData,
      async: false
      }).responseJSON;
      //console.log(jsonData);
      //ajax call

      var data = google.visualization.arrayToDataTable(jsonData);
     var now = new Date().toLocaleString('en-us',{year:'numeric'});

              // Some raw data (not necessarily accurate)
              var data = google.visualization.arrayToDataTable(jsonData);

              var options = {
                title : ' Received Call of YEAR: '+now,
                hAxis: {title: 'Date'},
                vAxis: {title: 'NO of Calls'},
                 colors: ['#008531', '#035496'],
                seriesType: 'bars',
                series: {1: {type: 'line'}}        };




      var chart = new google.visualization.ComboChart(document.getElementById('chart_div_2_sRMonthly'));
      chart.draw(data, options);
  }

}


//month sied sales call cournt
function drawChart_8_S(){
  google.charts.setOnLoadCallback(drawVisualization_61);

  function drawVisualization_61() {
      // Some raw data (not necessarily accurate)

      //ajax call
      var formData = {
      '_token':$('meta[name="csrf-token"]').attr('content'),
      };
      var jsonData = $.ajax({
      url: BASE_URL+'/getSalesClickCall',
      dataType: "json",
      type: "POST",
      data: formData,
      async: false
      }).responseJSON;
      //console.log(jsonData);
      //ajax call


              // Some raw data (not necessarily accurate)
              var data = google.visualization.arrayToDataTable([
                ['Month', 'OUT', 'Duration'],
                ['April',        938,     614.6],
                ['May',        1120,     682],
                ['June',      1167,     623],
                ['July',       1110,   609.4]

              ]);

              var options = {
                title : 'Last 3 Month OUT Call  (Click2Call)',
                vAxis: {title: 'sales Person'},
                hAxis: {title: 'NO of Calls'},
                seriesType: 'bars',
                series: {2: {type: 'line'}}        };




      var chart = new google.visualization.ComboChart(document.getElementById('achart_div_2_s'));
      chart.draw(data, options);
  }

}
//last 7 days sales call
function drawChart_7R_S(){
  google.charts.setOnLoadCallback(drawVisualization_61);

  function drawVisualization_61() {
      // Some raw data (not necessarily accurate)

      //ajax call
      var formData = {
      '_token':$('meta[name="csrf-token"]').attr('content'),
      };
      var jsonData = $.ajax({
      url: BASE_URL+'/getSalesAllCallRecieved',
      dataType: "json",
      type: "POST",
      data: formData,
      async: false
      }).responseJSON;
      //console.log(jsonData);
      //ajax call

      var data = google.visualization.arrayToDataTable(jsonData);
     var now = new Date().toLocaleString('en-us',{month:'long'});

              // Some raw data (not necessarily accurate)
              var data = google.visualization.arrayToDataTable(jsonData);

              var options = {
                title : ' Received Call of '+now,
                hAxis: {title: 'Date'},
                vAxis: {title: 'NO of Calls'},
                 colors: ['#008531', '#035496'],
                seriesType: 'bars',
                series: {1: {type: 'line'}}        };




      var chart = new google.visualization.ComboChart(document.getElementById('chart_div_2_sR'));
      chart.draw(data, options);
  }

}

//last 7 days sales call
function drawChart_7_S(){
  google.charts.setOnLoadCallback(drawVisualization_61);

  function drawVisualization_61() {
      // Some raw data (not necessarily accurate)

      //ajax call
      var formData = {
      '_token':$('meta[name="csrf-token"]').attr('content'),
      };
      var jsonData = $.ajax({
      url: BASE_URL+'/getSalesClickCallMonthwise',
      dataType: "json",
      type: "POST",
      data: formData,
      async: false
      }).responseJSON;
      //console.log(jsonData);
      //ajax call
      var data = google.visualization.arrayToDataTable(jsonData);
     var now = new Date().toLocaleString('en-us',{month:'long'});


              // Some raw data (not necessarily accurate)
              var data = google.visualization.arrayToDataTable(jsonData);

              var options = {
                title : 'OUT call of '+now+' (Click2Call)',
                hAxis: {title: 'Date'},
                vAxis: {title: 'NO of Calls'},
                 colors: ['#008031', '#114544'],
                seriesType: 'bars',
                series: {2: {type: 'line'}}        };




      var chart = new google.visualization.ComboChart(document.getElementById('chart_div_1_s'));
      chart.draw(data, options);
  }

}
//sales stop

function drawChart_6(){
  google.charts.setOnLoadCallback(drawVisualization_6);

  function drawVisualization_6() {
      // Some raw data (not necessarily accurate)

      //ajax call
      var formData = {
      '_token':$('meta[name="csrf-token"]').attr('content'),
      };
      var jsonData = $.ajax({
      url: BASE_URL+'/getWeeklyRecivedMissed_1',
      dataType: "json",
      type: "POST",
      data: formData,
      async: false
      }).responseJSON;
      //console.log(jsonData);
      //ajax call

      var data =new  google.visualization.arrayToDataTable(
        jsonData
      );

      var options = {
          title: 'Weekly Call details (API -2 :8929503295)',
          vAxis: {
              title: 'NO of calls'
          },
          hAxis: {
              title: 'Weeks Range'
          },
          isStacked: true,
          seriesType: 'bars',
          series: {
              5: {
                  type: 'line'
              }
          }
      };

      var chart = new google.visualization.ComboChart(document.getElementById('chart_div_6'));
      chart.draw(data, options);
  }

}





function drawChart_5(){
  google.charts.setOnLoadCallback(drawVisualization_5);

  function drawVisualization_5() {
      // Some raw data (not necessarily accurate)

      //ajax call
      var formData = {
      '_token':$('meta[name="csrf-token"]').attr('content'),
      };
      var jsonData = $.ajax({
      url: BASE_URL+'/getWeeklyRecivedMissed',
      dataType: "json",
      type: "POST",
      data: formData,
      async: false
      }).responseJSON;
      //console.log(jsonData);
      //ajax call

      var data =new  google.visualization.arrayToDataTable(
        jsonData
      );

      var options = {
          title: 'Weekly Call details (API -1 : 9999955922)',
          vAxis: {
              title: 'NO of calls'
          },
          hAxis: {
              title: 'Weeks Range'
          },
          isStacked: true,
          seriesType: 'bars',
          series: {
              5: {
                  type: 'line'
              }
          }
      };

      var chart = new google.visualization.ComboChart(document.getElementById('chart_div_5'));
      chart.draw(data, options);
  }

}



 function drawChart_4(){
  google.charts.setOnLoadCallback(drawVisualization_4);

   function drawVisualization_4() {
     //ajax call
     var formData = {
     '_token':$('meta[name="csrf-token"]').attr('content'),
     };
     var jsonData = $.ajax({
     url: BASE_URL+'/getLast30DaysAssignedQualifiedLead',
     dataType: "json",
     type: "POST",
     data: formData,
     async: false
     }).responseJSON;
     //console.log(jsonData);
     //ajax call


       // Some raw data (not necessarily accurate)
       var data = google.visualization.arrayToDataTable(jsonData);
  var now = new Date().toLocaleString('en-us',{month:'long'});

       var options = {
           title: 'Lead Assined /Qualified for '+now,
           vAxis: {
               title: 'No of Leads'
           },
           hAxis: {
               title: 'Date'
           },
           seriesType: 'bars',
           colors: ['#008031', '#114544'],
           is3D: true,
           isStacked: true,
           legend: {
               position: 'top',
               maxLines: 3
           },
           series: {
               5: {
                   type: 'line'
               }
           }
       };

       var chart = new google.visualization.ComboChart(document.getElementById('chart_div_4'));
       chart.draw(data, options);
   }

}

function drawChart_1(){
  google.charts.setOnLoadCallback(drawVisualization_1);

  function drawVisualization_1() {
      // Some raw data (not necessarily accurate)

      //ajax call
      var formData = {
      '_token':$('meta[name="csrf-token"]').attr('content'),
      };
      var jsonData = $.ajax({
      url: BASE_URL+'/getLast7DaysTotalCallAvgCall',
      dataType: "json",
      type: "POST",
      data: formData,
      async: false
      }).responseJSON;
      //console.log(jsonData);
      //ajax call

      var data =new  google.visualization.arrayToDataTable(
        jsonData
      );

      var options = {
          title: 'Call Received / Sales Person (Last 7 days)',
          vAxis: {
              title: 'NO of calls'
          },
          hAxis: {
              title: 'Sales Person'
          },
          isStacked: false,
          seriesType: 'bars',
          series: {
              1: {
                  type: 'line'
              }
          }
      };

      var chart = new google.visualization.ComboChart(document.getElementById('chart_div_1'));
      chart.draw(data, options);
  }

}




// start chart 3
function drawChart_3(){
  google.charts.setOnLoadCallback(drawVisualization_1);

  function drawVisualization_1() {
      // Some raw data (not necessarily accurate)

      //ajax call
      var formData = {
      '_token':$('meta[name="csrf-token"]').attr('content'),
      };
      var jsonData = $.ajax({
      url: BASE_URL+'/getLast30DaysRecievedOnlyCall',
      dataType: "json",
      type: "POST",
      data: formData,
      async: false
      }).responseJSON;
      //console.log(jsonData);
      //ajax call

      var data =new  google.visualization.arrayToDataTable(
        jsonData
      );

      var options = {
          title: 'Call Received / by Salesman last 30 Days',
          vAxis: {
              title: 'NO of Calls'
          },
          hAxis: {
              title: 'Salesman'
          },
          seriesType: 'bars',
          colors: ['green', 'red'],
          is3D: true,
          isStacked: false,
          legend: {
              position: 'top',
              maxLines: 3
          },
          series: {
              1: {
                  type: 'line'
              }
          }
      };


      var chart = new google.visualization.ComboChart(document.getElementById('chart_div_3'));
      chart.draw(data, options);
  }

}
//stop chart 3

// start chart 2
function drawChart_2(){
  google.charts.setOnLoadCallback(drawVisualization_1);

  function drawVisualization_1() {
      // Some raw data (not necessarily accurate)

      //ajax call
      var formData = {
      '_token':$('meta[name="csrf-token"]').attr('content'),
      };
      var jsonData = $.ajax({
      url: BASE_URL+'/getLast30DaysRecievedMissedCall',
      dataType: "json",
      type: "POST",
      data: formData,
      async: false
      }).responseJSON;
      //console.log(jsonData);
      //ajax call

      var data =new  google.visualization.arrayToDataTable(
        jsonData
      );
      var now = new Date().toLocaleString('en-us',{month:'long'});
      //basically converting whole date to string = "Fri Apr 2020'
      //then splitting by ' ' a space = ['Fri' 'Apr' '2020']
      //then selecting second element of array =
      //['Fri' 'Apr' '2020'].[1]
      //var currentMonth = now.toDateString().split(' ')[1];

      var options = {
          title: 'Call Received / Missed Call for '+now,
          vAxis: {
              title: 'NO of Calls'
          },
          hAxis: {
              title: 'Date'
          },
          seriesType: 'bars',
          colors: ['green', 'red'],
          is3D: true,
          isStacked: true,
          legend: {
              position: 'top',
              maxLines: 3
          },
          series: {
              5: {
                  type: 'line'
              }
          }
      };


      var chart = new google.visualization.ComboChart(document.getElementById('chart_div_2'));
      chart.draw(data, options);
  }

}
//stop chart 2
