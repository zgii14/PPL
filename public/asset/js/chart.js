document.addEventListener("DOMContentLoaded", function () {
  function renderChart(chartElement) {
      const labels = JSON.parse(chartElement.dataset.labels);
      const data = JSON.parse(chartElement.dataset.data);
      const ctx = chartElement.getContext('2d');

      new Chart(ctx, {
          type: 'doughnut',
          data: {
              labels: labels,
              datasets: [{
                  data: data,
                  backgroundColor: ['#4caf50', '#2196f3', '#ff9800', '#e91e63']
              }]
          },
          options: {
              responsive: true,
              plugins: {
                  legend: { position: 'top' }
              }
          }
      });
  }

  // Render charts dynamically
  document.querySelectorAll('canvas').forEach(canvas => {
      if (canvas.dataset.labels && canvas.dataset.data) {
          renderChart(canvas);
      }
  });
});