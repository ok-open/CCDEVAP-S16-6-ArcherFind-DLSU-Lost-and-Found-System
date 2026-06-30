
// MANAGE ACCOUNT: Password Change + Disable Account
document.addEventListener("DOMContentLoaded", () => {
    const currentPass = document.getElementById("current-pass");
    const newPass = document.getElementById("new-pass");
    const confirmPass = document.getElementById("confirm-pass");
    const saveBtn = document.getElementById("saveBtn");
    const disableBtn = document.getElementById("disableBtn");

    // CONFIRM NEW PASSWORD
    if (saveBtn) {
        saveBtn.addEventListener("click", async () => {
            const current = currentPass.value.trim();
            const newVal = newPass.value.trim();
            const confirmVal = confirmPass.value.trim();

            // All fields required
            if (!current || !newVal || !confirmVal) {
                showToast("⚠ Please fill out all password fields.", "var(--color-errorMsg)");
                flagFields([currentPass, newPass, confirmPass].filter(f => !f.value.trim()));
                return;
            }

            // New + Confirm must match
            if (newVal !== confirmVal) {
                showToast("⚠ New password and confirmation do not match.", "var(--color-errorMsg)");
                flagFields([newPass, confirmPass]);
                return;
            }

            // New must differ from Current
            if (newVal === current) {
                showToast("⚠ New password must be different from current password.", "var(--color-errorMsg)");
                flagFields([newPass]);
                return;
            }

            // Disable button while request is in flight
            saveBtn.disabled = true;
            saveBtn.textContent = "Saving...";

            try {
                // TODO: replace with real endpoint once backend is built
                const response = await fetch("/api/account/password", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        currentPassword: current,
                        newPassword: newVal
                    })
                });

                if (!response.ok) {
                    const errData = await response.json().catch(() => ({}));
                    throw new Error(errData.message || "Failed to update password.");
                }

                showToast("✓ Password updated successfully.", "var(--color-successMsg)");
                currentPass.value = "";
                newPass.value = "";
                confirmPass.value = "";

            } catch (err) {
                // Stub-friendly: backend doesn't exist yet, so network errors are expected for now
                showToast(`⚠ ${err.message || "Something went wrong. Please try again."}`, "var(--color-errorMsg)");
            } finally {
                saveBtn.disabled = false;
                saveBtn.textContent = "Confirm New Password";
            }
        });
    }

    // DISABLE ACCOUNT (UI only, no backend yet)
    if (disableBtn) {
        disableBtn.addEventListener("click", () => {
            const confirmed = confirm(
                "Are you sure you want to disable your account? This action cannot be undone."
            );

            if (!confirmed) return;

            // TODO: hook up to backend once disable-account endpoint exists
            showToast("⚠ Account disabling is not yet available.", "var(--color-errorMsg)");
        });
    }

    // Helper: flash red border on invalid fields
    function flagFields(fields) {
        fields.forEach((field) => {
            field.style.border = "1px solid var(--color-errorMsg)";
            clearTimeout(field._errorTimeout);
            field._errorTimeout = setTimeout(() => {
                field.style.border = "";
            }, 1500);
        });
    }
});