document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".controls");

    if (!form) return;

    const sort = form.querySelector("[name='sort']");
    const category = form.querySelector("[name='category']");

    sort.addEventListener("change", () => form.submit());
    category.addEventListener("change", () => form.submit());
});