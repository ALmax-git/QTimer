<div class="bg-secondary h-100 rounded p-4">
  <h6 class="mb-4">QTimer Live Requests</h6>
  <canvas id="qtimer-chart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  var ctx = document.getElementById("qtimer-chart").getContext("2d");
  var qtimerChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: [],
      datasets: [{
        label: "Requests per Second",
        borderColor: "rgba(235, 22, 22, .7)",
        backgroundColor: "rgba(235, 22, 22, .3)",
        data: []
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

  function fetchQTimerData() {
    fetch('/qtimer-requests')
      .then(response => response.json())
      .then(data => {
        qtimerChart.data.labels.push(data.timestamp);
        qtimerChart.data.datasets[0].data.push(data.request_count);

        // Limit data points to 10 for better visualization
        if (qtimerChart.data.labels.length > 10) {
          qtimerChart.data.labels.shift();
          qtimerChart.data.datasets[0].data.shift();
        }

        qtimerChart.update();
      })
      .catch(error => console.error("Error fetching data:", error));

    // Repeat every 1 second
    setTimeout(fetchQTimerData, 5000);
  }

  // Start fetching data on page load
  fetchQTimerData();
</script>
