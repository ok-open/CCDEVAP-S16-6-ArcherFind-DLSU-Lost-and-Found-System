// -------------------------- USER BUTTON -------------------------- //
const userButton = document.querySelector(".user-button");
const userProfile = document.querySelector(".user-profile");

userButton.addEventListener("click", (e) => {
    e.stopPropagation(); // prevents the click from bubbling up to document
    userProfile.classList.toggle("active");
});

// close when clicking anywhere outside
document.addEventListener("click", () => {
    userProfile.classList.remove("active");
});

// ---------------------------- DARK MODE --------------------
let darkmode = localStorage.getItem('darkmode');
const themeSwitch = document.querySelector(".day-night button");
const logos = document.querySelectorAll(".logo");

const enableDarkmode = () => {
    document.body.classList.add('darkmode');
    localStorage.setItem('darkmode', 'active');
    logos.forEach(logo => logo.src = "LOGOS/AF-DARKMODE.png");
}

const disableDarkmode = () => {
    document.body.classList.remove('darkmode');
    localStorage.setItem('darkmode', null);
    logos.forEach(logo => logo.src = "LOGOS/AF-ORIGINAL.png");
}

if (darkmode === "active") enableDarkmode();

themeSwitch.addEventListener("click", (e) => {
    e.stopPropagation(); // keeps panel open
    darkmode = localStorage.getItem('darkmode');
    darkmode !== "active" ? enableDarkmode() : disableDarkmode();
});