const currentUser = {
    first_name: "Dan",
    role: "Admin"
};

// Name print test
document.getElementById("username").textContent =
    currentUser.first_name;

const modal = document.getElementById("reportModal");
const root = document.documentElement;
const primaryColor = getComputedStyle(root).getPropertyValue('--color-primary').trim();
const secondaryColor = getComputedStyle(root).getPropertyValue('--color-secondary').trim();

// USER CHART
const ctx = document.getElementById('userChart');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Students', 'Staff', 'Admin',],
        datasets: [{
            data: [100, 10, 5]
        }]
    }, options: {
        responsive: true
    }
});

// ITEM REPORT PIE CHART
const itemReportChart = document.getElementById('itemReportChart');
new Chart(itemReportChart, {
    type: 'pie',
    data: {
        labels: ['Loss Item Reports', 'Claim Requests', 'Surrender Reports'],
        datasets: [{
            data: [162, 85, 68],
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            datalabels: {
                color: secondaryColor,
                font: {
                    family: '"DM Sans", sans-serif',
                    weight: '450',
                    size: 14
                },

                anchor: 'center',
                align: 'center',
                formatter: (value, ctx) => {
                    const sum = ctx.dataset.data.reduce((a, b) => a + b, 0);
                    const percentage = '(' + (value * 100 / sum).toFixed(1) + '%' + ')';
                    return [value, percentage];
                },

            },
            legend: {
                position: 'bottom'
            }
        }
    },
    plugins: [ChartDataLabels]
});


// INVENTORY STATUS PIE CHART
const inventoryChart = document.getElementById('inventoryChart');
new Chart(inventoryChart, {
    type: 'pie',
    data: {
        labels: ['In Storage', 'Claimed', 'Disposed'],
        datasets: [{
            data: [42, 21, 8],
            backgroundColor: ['#32e8ee', '#2897e1', '#FFCE56']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            datalabels: {
                color: secondaryColor,
                font: {
                    family: '"DM Sans", sans-serif',
                    weight: '450',
                    size: 14
                },
                formatter: (value, ctx) => {
                    const sum = ctx.dataset.data.reduce((a, b) => a + b, 0);
                    const percentage = '(' + (value * 100 / sum).toFixed(1) + '%' + ')';
                    return [value, percentage];
                }
            },
            legend: {
                position: 'bottom'
            }
        }
    },
    plugins: [ChartDataLabels]
});

// Line graph
const lineChartCanvas = document.getElementById('lineChart');
const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'];
const data = {
    labels: months,
    datasets: [{
        label: 'T Reports Per month',
        data: [65, 59, 80, 81, 56, 55, 40],
        fill: false,
        borderColor: primaryColor,
        backgroundColor: 'rgba(75, 192, 192, 0.1)',
        tension: 0.1,
        borderWidth: 2
    }]
};

new Chart(lineChartCanvas, {
    type: 'line',
    data: data,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// FOR FREQUENCY OF LOST ITEMS
initLostItemChart('lostItemFreqChart', 'Lost Item Frequency');

// button
document.getElementById("generateReportBtn").addEventListener("click", () => {
    modal.style.display = "flex";
});

document.getElementById("cancelBtn").addEventListener("click", () => {
    modal.style.display = "none";
});

document.getElementById("generateBtn").addEventListener("click", () => {
    const fromDate = document.getElementById("fromDate").value;
    const toDate = document.getElementById("toDate").value;

    if (!fromDate || !toDate) {
        alert("Please select both dates.");
        return;
    }

    localStorage.setItem("reportFrom", fromDate);
    localStorage.setItem("reportTo", toDate);
    window.location.href = "../../pages/admin/admin_generated-report.html";
});