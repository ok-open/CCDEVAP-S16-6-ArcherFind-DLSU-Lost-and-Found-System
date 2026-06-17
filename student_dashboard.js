// FOR REPORTS
const dummyStats = {
  "loss-reports": 4,
  "found-reports": 7,
  "approved-reports": 9,
  "pending-reports": 2
};

function renderStats(stats) {
  document.querySelectorAll(".stat-block").forEach(block => {
    const key = block.dataset.stat;
    const countEl = block.querySelector(".stat-count");
    if (stats[key] !== undefined) {
      countEl.textContent = stats[key];
    }
  });
}


// FOR FREQUENCY OF LOST ITEMS
const ctx = document.getElementById('myChart');

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
      label: '# of Votes',
      data: [12, 19, 3, 5, 2, 3],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

// FOR LATEST REPORTS
const dummyReports = [
  { id: 1, date: "June 03, 2026", type: "Loss Report", status: "Pending" },
  { id: 2, date: "June 05, 2026", type: "Found Report", status: "Verified" },
  { id: 3, date: "June 08, 2026", type: "Loss Report", status: "Claimed" },
  { id: 4, date: "June 11, 2026", type: "Found Report", status: "Pending" },
  { id: 5, date: "June 15, 2026", type: "Loss Report", status: "Rejected" },
];

function renderReports(reports) {
  const tbody = document.getElementById("report-body");

  tbody.innerHTML = reports.map(r => `
      <tr class="report-row" data-report-id="${r.id}">
        <td class="report-date">${r.date}</td>
        <td class="report-type">${r.type}</td>
        <td class="report-status status-${r.status.toLowerCase()}">${r.status}</td>
      </tr>
    `).join("");
}

renderStats(dummyStats);
renderReports(dummyReports);
