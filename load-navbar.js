document.addEventListener("DOMContentLoaded", function () {
    // 1. Get the current page filename (e.g., "admin_dashboard.html")
    const path = window.location.pathname;
    const page = path.split("/").pop();

    // 2. Determine which navbar file to pull based on the page prefix
    let navbarFile = "navbar-student.html"; // Default fallback

    if (page.startsWith("admin_")) {
        navbarFile = "NAVBAR-admin.html";
    } else if (page.startsWith("staff_")) {
        navbarFile = "NAVBAR-staff.html";
    } else if (page.startsWith("student_")) {
        navbarFile = "NAVBAR-student.html";
    }

    // 3. Fetch and inject the correct navbar
    fetch(navbarFile)
        .then(response => {
            if (!response.ok) throw new Error("Navbar file not found");
            return response.text();
        })
        .then(data => {
            document.getElementById("navbar-placeholder").innerHTML = data;
            
            // If you have interactive JS for your navbars (like dropdowns),
            // initialize those functions here after the HTML is loaded.
        })
        .catch(error => console.error("Error loading dynamic navbar:", error));
});