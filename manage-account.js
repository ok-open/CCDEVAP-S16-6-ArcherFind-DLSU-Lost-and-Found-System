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
    showToast("✓ Password updated successfully.");
});

document.getElementById("disableBtn").addEventListener("click", () => {
    if (confirm("Are you sure you want to disable your account?")) {
        showToast("✓ Account disabled successfully.", "#d9534f");
    }
});