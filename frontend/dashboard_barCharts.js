google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(drawInstitutionChart);

function drawInstitutionChart() {
  const rows = window.dashboardData || [];
  if (!rows.length) return;

  rows.forEach((row, index) => {

    const chartId = "barChart_" + (index + 1);

    const data = google.visualization.arrayToDataTable([
        ["Type", "Quantity",  { role: "style" }],
        ["Orders", row.total_orders, "color: #c3c3c3; opacity: 0.9;"],
        ["Top", row.total_top, "color: #1386d2; opacity: 0.6;"],
        ["Jacket", row.total_jacket, "color: #ff0000; opacity: 0.6;"],
        ["Labcoat", row.total_labcoat, "color: #f88b0e; opacity: 0.6;"],
        ["Polo", row.total_polo, "color: #14aa00; opacity: 0.6;"],
        ["Personalized", row.total_personalized, "color: #000000; opacity: 0.5;"],
    ]);

          var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

    const options = {
        title: "Total Orders/Items for " + row.institution,
        width: 600,
        height: 200,
        legend: { position: "none" },
    };

    const chart = new google.visualization.ColumnChart(document.getElementById(chartId));
    chart.draw(view, options);
  });
}
