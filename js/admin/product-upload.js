document.addEventListener("DOMContentLoaded", () => {

    const dropzone = document.getElementById("product-dropzone");
    if (!dropzone) return;

    const productId = dropzone.dataset.productId;

    const uploadFile = (file) => {
        const formData = new FormData();
        formData.append("image", file);
        formData.append("product_id", productId);

        fetch("/admin/products/upload-image", {
            method: "POST",
            body: formData,
            credentials: "include"
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.error);
            }
        });
    };

    dropzone.addEventListener("click", () => {
        const input = document.createElement("input");
        input.type = "file";
        input.accept = "image/*";
        input.onchange = () => uploadFile(input.files[0]);
        input.click();
    });

    dropzone.addEventListener("dragover", e => {
        e.preventDefault();
        dropzone.classList.add("dragover");
    });

    dropzone.addEventListener("dragleave", () => {
        dropzone.classList.remove("dragover");
    });

    dropzone.addEventListener("drop", e => {
        e.preventDefault();
        dropzone.classList.remove("dragover");
        uploadFile(e.dataTransfer.files[0]);
    });

});

document.querySelectorAll(".js-set-main").forEach(btn => {
    btn.addEventListener("click", () => {
        const formData = new FormData();
        formData.append("product_id", btn.dataset.productId);
        formData.append("image_id", btn.dataset.imageId);
        formData.append("action", "set_main");

        fetch("/admin/products/upload-image", {
            method: "POST",
            body: formData,
            credentials: "include"
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) location.reload();
            else alert(data.error);
        });
    });
});

document.querySelectorAll(".js-delete-image").forEach(btn => {
    btn.addEventListener("click", () => {
        if (!confirm("Usunąć to zdjęcie?")) return;

        const formData = new FormData();
        formData.append("product_id", btn.dataset.productId);
        formData.append("image_id", btn.dataset.imageId);
        formData.append("action", "delete");

        fetch("/admin/products/upload-image", {
            method: "POST",
            body: formData,
            credentials: "include"
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) location.reload();
            else alert(data.error);
        });
    });
});
