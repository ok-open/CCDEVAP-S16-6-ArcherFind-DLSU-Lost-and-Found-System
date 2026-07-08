document.addEventListener("DOMContentLoaded", () => {

    const error = document.body.dataset.error;

    if (!error) return;

    switch (error) {

        case "empty_fields":
            showToast(
                "⚠ Please fill in all fields.",
                "var(--color-errorMsg)"
            );
            break;

        case "invalid_email":
            showToast(
                "⚠ Please use your DLSU email address.",
                "var(--color-errorMsg)"
            );
            break;

        case "account_not_found":
            showToast(
            
                "⚠ No account found with that email.",
                "var(--color-errorMsg)"
            );
            break;

        case "wrong_password":
            showToast(
                "⚠ Incorrect password.",
                "var(--color-errorMsg)"
            );
            break;

        case "unauthorized":
            showToast(
                "⚠ Unauthorized access.",
                "var(--color-errorMsg)"
            );
            break;
    }

});