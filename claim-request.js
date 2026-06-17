document.addEventListener("DOMContentLoaded", () =>{
    const toast = document.getElementById("toast");
    const form = document.querySelector(".claim-form");
    const uploadBox = document.querySelector(".upload-box");

    function showToast(message, color = "#198754"){
        toast.textContent = message;
        toast.style.backgroundColor = color;

        toast.classList.add("show");

        setTimeout(() => {
            toast.classList.remove("show");
        }, 3000);
    }

    if (!form) return;

    form.addEventListener("submit", (e) =>{
        e.preventDefault();

        const building = document.querySelector("select.claim-input");
        const room = document.querySelector('input[type="number"]');
        const area = document.querySelector('input[type="text"]');
        const date = document.querySelector('input[type="date"]');
        const time = document.querySelector('input[type="time"]');
        const description = document.querySelector("textarea");

        let valid = true;

        if(!building.value || building.value === "Select Building"){
            valid = false;
        }

        if(!room.value.trim()){
            valid = false;
        }

        if(!area.value.trim()){
            valid = false;
        }

        if(!date.value){
            valid = false;
        }

        if(!time.value){
            valid = false;
        }

        if(!description.value.trim()){
            valid = false;
        }

        if(!valid){
            showToast("⚠ Please complete all required fields.", "#d9534f");
            return;
        }

        showToast("✓ Claim request submitted successfully!");

        form.reset();

        if(uploadBox && uploadBox.resetPreview){
            uploadBox.resetPreview();
        }
    });
});