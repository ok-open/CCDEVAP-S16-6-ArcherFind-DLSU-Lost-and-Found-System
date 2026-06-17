/**
 * Reusable Lost Item Frequency Chart
 * Used by both admin_dashboard.html and student_dashboard.html
 * 
 * Usage:
 * - Include this file in your HTML
 * - Call initLostItemChart(canvasId, chartLabel, options)
 * - Uses shared location data across all instances
 * 
 * Example:
 * initLostItemChart('myChart', 'Lost Item Frequency')
 */

// Shared location data used by all dashboards
const LOST_ITEM_LOCATIONS = {
    labels: [
        'Gokongwei Hall',
        'Andrew Hall',
        'St. La Salle Hall',
        'Saint Joseph',
        'Henry Library',
        'Bloemen Cafeteria',
        'Razon Gym'
    ],
    data: [
        Math.floor(Math.random() * 30) + 10,
        Math.floor(Math.random() * 30) + 10,
        Math.floor(Math.random() * 30) + 10,
        Math.floor(Math.random() * 30) + 10,
        Math.floor(Math.random() * 30) + 10,
        Math.floor(Math.random() * 30) + 10,
        Math.floor(Math.random() * 30) + 10
    ]
};

function initLostItemChart(canvasId, chartLabel, customOptions = {}) {
    const ctx = document.getElementById(canvasId);
    
    if (!ctx) {
        console.error(`Canvas element with ID '${canvasId}' not found`);
        return;
    }

    // Default chart options
    const defaultOptions = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    // Merge custom options with defaults
    const options = { ...defaultOptions, ...customOptions };

    // Create the chart with shared location data
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: LOST_ITEM_LOCATIONS.labels,
            datasets: [{
                label: chartLabel,
                data: LOST_ITEM_LOCATIONS.data,
                borderWidth: 1,
                backgroundColor: 'rgba(61, 87, 65, 0.2)',
                borderColor: 'rgba(61, 87, 65, 0.8)'
            }]
        },
        options: options
    });
}
