document.addEventListener("DOMContentLoaded", () => {
    const TOAST_DURATION = 6000;
    const form = document.querySelector(".form-wrapper");
    const nameInput = document.querySelector('input[name="name"]');

    if (!form) return;

    const building = document.getElementById("building_id");
    const floor = document.getElementById("floor_number");
    const room = document.getElementById("room_id");
    const area = document.getElementById("area_id");

    const modal = window.createModal({
        modalId: "confirm-modal",
        textId: "confirm-modal-text",
        cancelId: "confirm-modal-cancel",
        confirmId: "confirm-modal-yes",
        confirmText: "Yes",
        message: () => `Are you sure you want to submit this item: ${getItemName()}?`
    });

    function getItemName() {
        const typedName = nameInput?.value?.trim();
        return typedName ? typedName : "this item";
    }

    modal.onConfirm(() => {
        form.dataset.confirmed = "true";
        form.submit();
    });

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

    function resetLocationSelections() {
        room.selectedIndex = 0;
        area.selectedIndex = 0;
    }

    // ==========================================
    // LOCATION SELECTION LISTENERS
    // ==========================================

    building.addEventListener("change", () => {
        floor.value = "";
        resetLocationSelections();

        const selected = building.options[building.selectedIndex];
        floor.max = selected.dataset.maxLevel || "";

        filterLocations();
    });

    floor.addEventListener("input", () => {
        resetLocationSelections();
        filterLocations();
    });

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

    // Hide everything initially
    filterLocations();

    // ==========================================
    // FORM SUBMISSION
    // ==========================================

    form.addEventListener("submit", (e) => {
        if (form.dataset.confirmed === "true") {
            form.dataset.confirmed = "";
            return;
        }

        e.preventDefault();

        // Custom validation for location fields
        const hasRoom = room.value !== "";
        const hasArea = area.value !== "";
        const hasLocation = hasRoom || hasArea;

        if (!building.value || !floor.value || !hasLocation) {
            showToast(
                "⚠ Please complete all required fields.",
                "var(--color-errorMsg)"
            );
            return;
        }

        // Use browser validation for other required fields (name, category, brand, dates, etc.)
        if (!form.reportValidity()) {
            return;
        }

        modal.open();
    });

    // ==========================================
    // SUCCESS / ERROR TOASTS
    // ==========================================

    const params = new URLSearchParams(window.location.search);

    if (params.get("success") === "submitted") {
        const itemName = params.get("item");
        const message = itemName
            ? `✓ Item report for "${itemName}" was submitted successfully!`
            : "✓ Item report submitted successfully!";
        showToast(message, "var(--color-successMsg)", TOAST_DURATION);
    }

    if (params.get("error") === "failed") {
        showToast("⚠ Failed to submit report. Please try again.", "var(--color-errorMsg)", TOAST_DURATION);
    }
});