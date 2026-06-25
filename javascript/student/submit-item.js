const toast = document.getElementById("toast");

function showToast(message, color = "#198754"){
    toast.textContent = message;
    toast.style.backgroundColor = color;

    toast.classList.add("show");

    setTimeout(() =>{
        toast.classList.remove("show");
    }, 3000);
}

document.addEventListener("DOMContentLoaded", () =>{
    const form = document.querySelector(".surrender-form");
    const uploadBoxes = document.querySelectorAll(".upload-box");

    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const inputs = document.querySelectorAll(".input-box, textarea");
        let valid = true;

        inputs.forEach(input =>{
            if(
                input.value.trim() === "" ||
                input.value === "Select Category" ||
                input.value === "Select Building"
            ){
                valid = false;
            }
        });

        if(!valid){
            showToast("⚠ Please complete all required fields.", "var(--color-errorMsg)");
            return;
        }

        showToast("✓ Item submitted successfully!");

        form.reset();

        uploadBoxes.forEach(box =>{
            if (box.resetPreview) box.resetPreview();
        });
    });
});