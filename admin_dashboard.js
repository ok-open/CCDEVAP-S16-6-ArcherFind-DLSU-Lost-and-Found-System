const currentUser = {
    first_name: "Dan",
    role: "Admin"
};
//Name print test
document.getElementById("username").textContent =
    currentUser.first_name;

const ctx = document.getElementById('userChart');

new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Students', 'Staff', 'Admin',],
        datasets: [{
            data: [100,10,5]
        }]
    }, options: {
        responsive:true
    }
});

const modal = document.getElementById("reportModal");

document
    .getElementById("generateReportBtn").addEventListener("click", () => {
    modal.style.display = "flex"; });

document.getElementById("cancelBtn").addEventListener("click", () => { 
    modal.style.display = "none";});

document.getElementById("generateBtn").addEventListener("click", () => {

        const fromDate = document.getElementById("fromDate").value;

        const toDate = document.getElementById("toDate").value;

        if (!fromDate || !toDate) {
            alert("Please select both dates.");
            return;
        }

        localStorage.setItem("reportFrom", fromDate);

        localStorage.setItem("reportTo", toDate);

        window.location.href = "admin_generated-report.html"; });