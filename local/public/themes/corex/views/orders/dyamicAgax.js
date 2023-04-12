$.ajax({
    url: BASE_URL+'/getFilteruserWiseStageCompleted',
    type: 'POST',
    data: formData,
    success: function(res) {
     
      $.each(res, function(key, value){

        console.log(value.step_name);
        
        var data = google.visualization.arrayToDataTable(value.step_data);    
        var options = {
          title : value.step_name+" Total:"+value.step_totalCount,
           
          seriesType: 'bars',
          series: {1: {type: 'line'}},
          colors: ['#008080', '#e6693e', '#ec8f6e', '#f3b49f', '#f6c7b6']
        };
        var dyamicID=value.step_code;
        var chart = new google.visualization.ComboChart(document.getElementById(dyamicID));
        chart.draw(data, options);
        google.charts.setOnLoadCallback(drawChart);
  

      
      });
    },
    dataType : 'json'
  });