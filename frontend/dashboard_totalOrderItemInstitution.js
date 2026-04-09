google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawInstitutionChart);

function drawInstitutionChart() {
  const total = window.dashboardData || [];
  if (!total.length) return;

    const dataArray = [["Institution", "Total Orders", "Total Items"]];

    total.forEach(element => {
        dataArray.push([element.institution, element.total_orders, element.total_items]);
    });


    const data = google.visualization.arrayToDataTable(dataArray);
      const options = {
    title: "Total Orders & Items Between Institutions",
    bars: 'horizontal',
    legend: { position: "top" },
      colors: [
    "#abacae", // Total Orders (blue)
    "#722cdc",  // Total Items (purple)
    ],
    chartArea: {
      left: 110
    },
    backgroundColor: 'transparent'
  };
      const chart = new google.visualization.BarChart(document.getElementById("columnChart_totalOrderItem_between_all_Institutions"));
    chart.draw(data, options);
}


