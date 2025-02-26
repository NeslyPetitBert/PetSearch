Chart.pluginService.register({
  beforeDraw: function (chart) {
      if (chart.config.options.elements.center) {
          //Get ctx from string
          var ctx = chart.chart.ctx;

          //Get options from the center object in options
          var centerConfig = chart.config.options.elements.center;
          var fontStyle = centerConfig.fontStyle || 'Arial';
          var txt = centerConfig.text;
          var color = centerConfig.color || '#000';
          var sidePadding = centerConfig.sidePadding || 20;
          var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
          //Start with a base font of 30px
          ctx.font = "30px " + fontStyle;

          //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
          var stringWidth = ctx.measureText(txt).width;
          var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

          // Find out how much the font can grow in width.
          var widthRatio = elementWidth / stringWidth;
          var newFontSize = Math.floor(30 * widthRatio);
          var elementHeight = (chart.innerRadius * 2);

          // Pick a new font size so it will not be larger than the height of label.
          var fontSizeToUse = Math.min(newFontSize, elementHeight);

          //Set font settings to draw it correctly.
          ctx.textAlign = 'center';
          ctx.textBaseline = 'middle';
          var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
          var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
          ctx.font = fontSizeToUse+"px " + fontStyle;
          ctx.fillStyle = color;

          //Draw text in center
          ctx.fillText(txt, centerX, centerY);
      }
  }
});

function renderChart(data, labels) {
  
  var ctx = document.getElementById("emailChart");

  var myPieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        //  labels:['1','2'],
          labels: labels,
          datasets: [{
              data: data,
             // data:[12542,1],
              backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#520020', 'mediumorchid'],
              hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', 'rebeccapurple', 'darkorchid'],
              hoverBorderColor: "rgba(234, 236, 244, 1)"
          }]
      },
      options: {
          maintainAspectRatio: false,
          tooltips: {
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              borderColor: '#dddfeb',
              borderWidth: 0,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              caretPadding: 0
          },
 
          legend: {
              display: true
          },
          cutoutPercentage: 0
      }
  });
}

$(document).ready(function() {
  $.ajax({
      url : '/dashboard/user/mail',
      type: 'GET',
      async: true,
      success: function (data) {
        console.log()
          renderChart(data['Data'], data['Labels'])
      }
  });
});