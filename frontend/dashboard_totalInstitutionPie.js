google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(drawInstitutionChart);

function drawInstitutionChart() {
  const totalItems = window.dashboardData || [];
  if (!totalItems.length) return;

    const dataArray = [["Institution", "Total Items"]];

    totalItems.forEach(element => {
        dataArray.push([element.institution, element.total_items]);
    });


    const data = google.visualization.arrayToDataTable(dataArray);
      const options = {
        title: "Total Items % Between Institutions (Top+Jacket+Labcoat+Polo)",
        pieHole: 0.35, // donut 
        sliceVisibilityThreshold: 0,
          // pieSliceText: 'label',
        slices: {    1: { offset: 0.2 }, // Jacket
                      3: { offset: 0.25 } // Polo
                },
        legend: { position: "right" }
      };
      const chart = new google.visualization.PieChart(document.getElementById("donutChart_totalItems_between_all_Institutions"));
    chart.draw(data, options);
}


