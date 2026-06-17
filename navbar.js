// -------------------------- USER BUTTON -------------------------- //
const userButtons = document.querySelectorAll(".user-button");

// Helper to close all open profiles
function closeAllProfiles() {
    document.querySelectorAll(".user-profile.active").forEach(p => p.classList.remove("active"));
}

userButtons.forEach((wrapper) => {
    const button = wrapper.querySelector("button") || wrapper;
    const profile = wrapper.querySelector(".user-profile");
    if (!profile) return;

    // toggle profile for this wrapper
    button.addEventListener("click", (e) => {
        e.stopPropagation(); // prevents the click from bubbling up to document
        document.querySelectorAll(".user-profile.active").forEach(p => {
            if (p !== profile) p.classList.remove("active");
        });
        profile.classList.toggle("active");
    });

    // attach the internal buttons for this profile specifically
    const logOutButton = profile.querySelector(".log-out button") || profile.querySelector(".log-out");
    const manageAccountButton = profile.querySelector(".manage-account");
    const viewDashboardButton = profile.querySelector(".view-dashboard button") || profile.querySelector(".view-dashboard");
    const dayNightButton = profile.querySelector(".day-night button");

    if (logOutButton) {
        logOutButton.addEventListener("click", (e) => {
            e.stopPropagation();
            window.location.href = 'login.html';
        });
    }

    if (manageAccountButton) {
        manageAccountButton.addEventListener("click", (e) => {
            e.stopPropagation();
            window.location.href = 'student_manage-account.html';
        });
    }

    if (viewDashboardButton) {
        viewDashboardButton.addEventListener("click", (e) => {
            e.stopPropagation();
            window.location.href = 'student_dashboard.html';
        });
    }

    if (dayNightButton) {
        dayNightButton.addEventListener("click", (e) => {
            e.stopPropagation(); // keeps panel open
            let darkmode = localStorage.getItem('darkmode');
            darkmode !== "active" ? enableDarkmode() : disableDarkmode();
        });
    }
});

// close when clicking anywhere outside
document.addEventListener("click", () => {
    closeAllProfiles();
});

// ---------------------------- DARK MODE ------------------------------ 
let darkmode = localStorage.getItem('darkmode');

const enableDarkmode = () => {
    document.body.classList.add('darkmode');
    localStorage.setItem('darkmode', 'active');
    const logos = document.querySelectorAll(".logo");
    if (logos && logos.length) logos.forEach(logo => { if (logo) logo.src = "LOGOS/AF-DARKMODE.png"; });
    const aboutImg = document.querySelector('#banner img');
    if (aboutImg) aboutImg.src = "styles/BACKGROUNDS/AboutDark.png";
}

const disableDarkmode = () => {
    document.body.classList.remove('darkmode');
    localStorage.setItem('darkmode', null);
    const logos = document.querySelectorAll(".logo");
    if (logos && logos.length) logos.forEach(logo => { if (logo) logo.src = "LOGOS/AF-ORIGINAL.png"; });
    const aboutImg = document.querySelector('#banner img');
    if (aboutImg) aboutImg.src = "styles/BACKGROUNDS/About.png";
}

if (darkmode === "active") enableDarkmode();


// ------------------------------ SIDEBAR ------------------------------ 
const sidebarOpenCloseButton = document.querySelector(".sidebar-open-close button");
const sidebar = document.querySelector(".sidebar");

if (sidebarOpenCloseButton) {
    sidebarOpenCloseButton.addEventListener("click", () => {
        sidebar.classList.toggle("open");
    });
}