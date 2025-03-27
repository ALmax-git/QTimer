<div class="container-fluid">
  <div class="row g-4">
    <div class="col-sm-12 col-xl-6">
      <div class="bg-secondary h-100 rounded p-4">
        <h6 class="mb-4">QTimer Live Requests (Every 2 Minutes)</h6>
        <canvas id="line-chart"></canvas>
      </div>
    </div>
    <div class="col-sm-12 col-xl-6">
      <div class="h-100 bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h6 class="mb-0">Calender</h6>
          <a href="#">Show All</a>
        </div>
        <div id="calender"></div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  var ctx = document.getElementById("line-chart").getContext("2d");
  var qtimerChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: [],
      datasets: [{
        label: "Requests (Last 20 Mins)",
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
        qtimerChart.data.labels = data.map(entry => entry.created_at.substring(11, 16)); // Extract HH:mm
        qtimerChart.data.datasets[0].data = data.map(entry => entry.count);
        qtimerChart.update();
      })
      .catch(error => console.error("Error fetching data:", error));

    // Fetch data every 2 minutes (120,000 milliseconds)
    setTimeout(fetchQTimerData, 120000);
  }

  // Start fetching data on page load
  fetchQTimerData();
</script>
