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

const locationCtx = document.getElementById('locationChart');

new Chart(locationCtx, {
    type: 'bar',
    data: {
        labels: [
            'Gokongwei Hall',
            'Andrew Hall',
            'LS Hall',
            'Library'
        ],
        datasets: [{
            label: 'Lost Items',
            data: [25, 18, 12, 9]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});