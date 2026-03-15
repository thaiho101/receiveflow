google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(drawInstitutionChart);

function drawInstitutionChart() {
  const rows = window.dashboardData || [];
  if (!rows.length) return;

  rows.forEach((row, index) => {

    const chartId = "donutChart_" + (index + 1);

    const data = google.visualization.arrayToDataTable([
        ["Type", "Quantity",  { role: "style" }],
        ["Top", row.total_top, "color: #17A589; opacity: 0.6;"],
        ["Jacket", row.total_jacket, "color: #1B4F72; opacity: 0.6;"],
        ["Labcoat", row.total_labcoat, "color: #95a0ac; opacity: 0.6;"],
        ["Polo", row.total_polo, "color: #7c28b4; opacity: 0.6;"],
    ]);

          var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

    const options = {
        title: "Item Distribution Percentage (Excluding Orders & Personalized) - " + row.institution,
        sliceVisibilityThreshold: 0,
        is3D: true
    };

    const chart = new google.visualization.PieChart(document.getElementById(chartId));
    chart.draw(view, options);
  });
}
