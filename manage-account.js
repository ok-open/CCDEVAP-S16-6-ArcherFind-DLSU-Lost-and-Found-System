const toast = document.getElementById("toast");

function showToast(message, color = "#198754") {
    toast.textContent = message;
    toast.style.backgroundColor = color;

    toast.classList.add("show");

    setTimeout(() => {
        toast.classList.remove("show");
    }, 3000);
}

document.getElementById("saveBtn").addEventListener("click", () => {
    const currentPass = document.getElementById("current-pass").value.trim();
    const newPass = document.getElementById("new-pass").value.trim();

    if(!currentPass || !newPass){
        showToast("⚠ Please fill in all password fields.", "var(--color-errorMsg)");
        return;
    }
    if(newPass.length < 6){
        showToast("⚠ Password must be at least 6 characters.", "var(--color-errorMsg)");
        return;
    }
    showToast("✓ Password updated successfully.");
});

document.getElementById("disableBtn").addEventListener("click", () => {
    const confirmed = confirm("Are you sure you want to disable your account?");
    if(confirmed){
        showToast("✓ Account disabled successfully.", "var(--color-errorMsg)");
    }
});