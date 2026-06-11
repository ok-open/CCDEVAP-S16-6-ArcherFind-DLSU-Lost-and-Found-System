// -------------------------- DROPDOWN MENU  -------------------------- //
const dropdown = document.querySelector('.dropdown');
const menu = document.querySelector('.dropdown-menu');
const header = document.querySelector('header');

let hideTimeout; // stores the setTimeout so we can cancel it if needed

// when cursor enters .dropdown, position and show the menu
dropdown.addEventListener('mouseenter', () => {
    clearTimeout(hideTimeout); // cancel any pending hide
    const rect = dropdown.getBoundingClientRect();
    const headerBottom = header.getBoundingClientRect().bottom;

    menu.style.top = headerBottom + 'px'; // flush below header
    menu.style.left = rect.left + 'px';   // aligned with .dropdown
    menu.classList.add('active');
});

// when cursor leaves .dropdown, wait a bit before hiding
// (this gives time for cursor to reach the menu across the gap)
dropdown.addEventListener('mouseleave', () => {
    hideTimeout = setTimeout(() => {
        if (!menu.matches(':hover')) { // only hide if cursor isn't on the menu
            menu.classList.remove('active');
        }
    }, 250);
});

// if cursor reaches the menu in time, cancel the hide
menu.addEventListener('mouseenter', () => {
    clearTimeout(hideTimeout);
});

// hide when cursor leaves the menu
menu.addEventListener('mouseleave', () => {
    menu.classList.remove('active');
});

// -------------------------- USER BUTTON -------------------------- //
const user = document.getElementById("user-button");
user.addEventListener("click", function() {
    alert("TEST if the button works. it should work");
});