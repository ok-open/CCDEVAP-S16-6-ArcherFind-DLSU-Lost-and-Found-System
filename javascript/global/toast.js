function showToast(message, color) {
    const toast = document.getElementById("toast");
    if (!toast) {
    console.warn("No #toast element found on this page.");
    return;
    }

    toast.textContent = message;
    toast.style.backgroundColor = color;
    toast.classList.add("show-toast");
    
    clearTimeout(toast._hideTimeout); // avoid overlapping timers if toast fires again quickly

    toast._hideTimeout = setTimeout(() => {
        toast.classList.remove("show-toast");
    }, 2500);
}
