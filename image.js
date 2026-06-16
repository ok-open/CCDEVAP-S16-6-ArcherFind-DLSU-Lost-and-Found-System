document.addEventListener("DOMContentLoaded", () => {
    const uploadBoxes = document.querySelectorAll(".upload-box");

    uploadBoxes.forEach(box => {
        const input = box.querySelector("input[type='file']");
        const img = box.querySelector(".preview-image");
        const text = box.querySelector(".upload-text");

        input.addEventListener("change", function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();

            reader.onload = function (e) {
                img.src = e.target.result;
                img.style.display = "block";
                text.style.display = "none";
            };

            reader.readAsDataURL(file);
        });
    });
});