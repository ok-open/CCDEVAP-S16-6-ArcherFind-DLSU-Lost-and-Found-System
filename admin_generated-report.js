                                                                                                                        const userCtx = document.getElementById('userChart');

new Chart(userCtx, {
    type: 'doughnut',
    data: {
        labels: ['Students', 'Staff', 'Admin'],
        datasets: [{
            data: [100, 10, 5]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// FOR LOST ITEM FREQUENCY BY LOCATION
initLostItemChart('locationChart', 'Lost Items by Location');