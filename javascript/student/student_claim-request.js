document.addEventListener("DOMContentLoaded", () => {

    const toast = document.getElementById("toast");
    const form = document.querySelector(".claim-form");

    if (!form) return;

    const building = document.getElementById("building_id");
    const floor = document.getElementById("floor_number");
    const room = document.getElementById("room_id");
    const area = document.getElementById("area_id");

    function showToast(message, color = "#198754") {

        toast.textContent = message;
        toast.style.backgroundColor = color;

        toast.classList.add("show");

        setTimeout(() => {
            toast.classList.remove("show");
        }, 3000);

    }

    // ==========================================
    // FILTER ROOMS AND AREAS
    // ==========================================

    function filterLocations() {

        const selectedBuilding = building.value;
        const selectedFloor = floor.value;

        Array.from(room.options).forEach(option => {

            if (option.value === "") {
                option.hidden = false;
                option.disabled = false;
                return;
            }

            const visible =
                option.dataset.building === selectedBuilding &&
                option.dataset.level === selectedFloor;

            option.hidden = !visible;
            option.disabled = !visible;

        });

        Array.from(area.options).forEach(option => {

            if (option.value === "") {
                option.hidden = false;
                option.disabled = false;
                return;
            }

            const visible =
                option.dataset.building === selectedBuilding &&
                option.dataset.level === selectedFloor;

            option.hidden = !visible;
            option.disabled = !visible;

        });

    }

    // ==========================================
    // BUILDING CHANGED
    // ==========================================

    building.addEventListener("change", () => {

        floor.value = "";

        room.selectedIndex = 0;
        area.selectedIndex = 0;

        const selected =
            building.options[building.selectedIndex];

        floor.max = selected.dataset.maxLevel || "";

        filterLocations();

    });

    // ==========================================
    // FLOOR CHANGED
    // ==========================================

    floor.addEventListener("input", () => {

        room.selectedIndex = 0;
        area.selectedIndex = 0;

        filterLocations();

    });

    // Hide everything initially
    filterLocations();

    // ==========================================
    // ALLOW ONLY ONE LOCATION
    // ==========================================

    room.addEventListener("change", () => {

        if (room.value !== "") {
            area.value = "";
            area.disabled = true;
        } else {
            area.disabled = false;
        }

    });

    area.addEventListener("change", () => {

        if (area.value !== "") {
            room.value = "";
            room.disabled = true;
        } else {
            room.disabled = false;
        }

    });

    // ==========================================
    // FORM VALIDATION
    // ==========================================

    form.addEventListener("submit", (e) => {

        const date = document.querySelector("[name='date_lost']");
        const time = document.querySelector("[name='time_lost']");
        const description = document.querySelector("[name='description']");

        let valid = true;

        if (building.value === "") {
            valid = false;
        }

        if (floor.value === "") {
            valid = false;
        }

        if (room.value === "" && area.value === "") {
            valid = false;
        }

        if (date.value === "") {
            valid = false;
        }

        if (time.value === "") {
            valid = false;
        }

        if (description.value.trim() === "") {
            valid = false;
        }

        if (!valid) {

            e.preventDefault();

            showToast(
                "⚠ Please complete all required fields.",
                "var(--color-errorMsg)"
            );

        }

    });

    // ==========================================
    // SUCCESS / ERROR TOASTS
    // ==========================================

    const params = new URLSearchParams(window.location.search);

    if (params.get("success") === "submitted") {

        showToast(
            "✓ Claim request submitted successfully!"
        );

    }

    if (params.get("error") === "failed") {

        showToast(
            "⚠ Failed to submit claim request.",
            "var(--color-errorMsg)"
        );

    }

});