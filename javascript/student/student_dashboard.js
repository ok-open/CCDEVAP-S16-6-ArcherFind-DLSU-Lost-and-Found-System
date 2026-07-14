document.addEventListener("DOMContentLoaded", () => {

    fetch("../../controllers/StudentDashboardController.php")

        .then(response => response.json())

        .then(data => {

            renderStats(data.stats);

            renderReports(data.reports);

            renderChart(data.chart);

        })

        .catch(error => {

            console.error(
                "Dashboard Error:",
                error
            );

        });

});




// ==========================================
// RENDER STATISTICS CARDS
// ==========================================

function renderStats(stats) {

    document
        .querySelectorAll(".stat-block")
        .forEach(block => {

            const key = block.dataset.stat;

            const count =
                block.querySelector(".stat-count");


            if (stats[key] !== undefined) {

                count.textContent = stats[key];

            }

        });

}




// ==========================================
// RENDER REPORT HISTORY TABLE
// ==========================================

function renderReports(reports) {

    const tbody =
        document.getElementById("report-body");


    if (!reports.length) {

        tbody.innerHTML =

        `
        <tr>
            <td colspan="3">
                No reports submitted yet.
            </td>
        </tr>
        `;

        return;

    }



    tbody.innerHTML =

        reports.map(report =>

        `
        <tr class="report-row">

            <td>
                ${report.date}
            </td>

            <td>
                ${report.type}
            </td>

            <td class="status-${report.status.toLowerCase()}">
                ${report.status}
            </td>

        </tr>
        `

        ).join("");

}




// ==========================================
// RENDER LOST ITEM FREQUENCY CHART
// ==========================================

function renderChart(chartData) {


    initLostItemChart(

        "ITEM",

        "Lost Item Frequency",

        {

            labels:
                chartData.map(
                    item => item.location
                ),


            data:
                chartData.map(
                    item => item.total
                )

        }

    );

}