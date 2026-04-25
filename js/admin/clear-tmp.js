
window.addEventListener("beforeunload", () => {
    navigator.sendBeacon("/admin/products/clear-temp");
});

document.querySelector(".back-link")?.addEventListener("click", () => {
    fetch("/admin/products/clear-temp", { method: "POST" });
});
