// ID NUMBER: Digits Only
const idNum = document.getElementById('id-num');
idNum.onkeydown = (event) => {
    // Only allow if the e.key value is a number or if it's 'Backspace'
    if (isNaN(event.key) && event.key !== 'Backspace') {
        event.preventDefault();
        showToast("⚠ Only numeric digits are allowed.", "var(--color-errorMsg)");

        // Change border to red for 1500ms
        idNum.style.border = "1px solid var(--color-errorMsg)";
        clearTimeout(idNum._errorTimeout);
        idNum._errorTimeout = setTimeout(() => {
            idNum.style.border = "";
        }, 1500);
    }
};

// PASSWORD: Toggle Visibility
function togglePassVisibility() {
    const buttons = document.querySelectorAll(".see-pass");

    buttons.forEach((button) => {
        const field = button.previousElementSibling; // the <input> right before this button

        const showPassword = () => {
            field.type = "text";
            button.classList.add("active");
        };

        const hidePassword = () => {
            field.type = "password";
            button.classList.remove("active");
        };

        // Mouse events (desktop)
        button.addEventListener("mousedown", showPassword);
        button.addEventListener("mouseup", hidePassword);
        button.addEventListener("mouseleave", hidePassword);

        // Touch events (mobile)
        button.addEventListener("touchstart", (e) => {
            e.preventDefault();
            showPassword();
        });
        button.addEventListener("touchend", hidePassword);
        button.addEventListener("touchcancel", hidePassword);
    });
}

togglePassVisibility();