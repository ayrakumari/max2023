am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end
    
    // Create chart instance
    var chart = am4core.create("chartdiv_LeadQualified", am4charts.XYChart);
    // Add percent sign to all numbers
    chart.numberFormatter.numberFormat = "#.#'";


    //ajax call
    var formData = {
      '_token':$('meta[name="csrf-token"]').attr('content'),
      };
      var jsonData = $.ajax({
      url: BASE_URL+'/getAllSalseMemberLeadTrackDays',
      dataType: "json",
      type: "POST",
      data: formData,
      async: false
      }).responseJSON;
      //console.log(jsonData);
      //ajax call

    // Add data
    chart.data =jsonData;
    
    // Create axes
var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "name";
categoryAxis.renderer.grid.template.location = 0;
categoryAxis.renderer.minGridDistance = 30;
categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
  if (target.dataItem && target.dataItem.index & 2 == 2) {
    return dy + 25;
  }
  return dy;
});

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Lead Stage  of 7 Days";
valueAxis.title.fontWeight = 800;

// Create series
var series = chart.series.push(new am4charts.ColumnSeries());
series.dataFields.valueY = "assined";
series.dataFields.categoryX = "name";
series.clustered = false;
series.tooltipText = "Lead Assined to {categoryX} : [bold]{valueY}[/]";

var series2 = chart.series.push(new am4charts.ColumnSeries());
series2.dataFields.valueY = "qualified";
series2.dataFields.categoryX = "name";
series2.clustered = false;
series2.columns.template.width = am4core.percent(50);
series2.tooltipText = "Lead Qualified by {categoryX} : [bold]{valueY}[/]";


var series3 = chart.series.push(new am4charts.ColumnSeries());
series3.dataFields.valueY = "sampling";
series3.dataFields.categoryX = "name";
series3.clustered = true;
series3.columns.template.width = am4core.percent(50);
series3.tooltipText = "Lead Sampling by {categoryX} : [bold]{valueY}[/]";
series3.propertyFields.stroke = "#008080";
series3.propertyFields.fill =  am4core.color("#035496");


chart.cursor = new am4charts.XYCursor();
chart.cursor.lineX.disabled = true;
chart.cursor.lineY.disabled = true;

}); // end am4core.ready()