document.addEventListener("DOMContentLoaded", () => {

    const dropzone = document.getElementById("product-dropzone-temp");
    const preview = document.getElementById("temp-images-preview");

    if (!dropzone) return;

    const uploadFile = (file) => {
        const formData = new FormData();
        formData.append("image", file);

        fetch("/admin/products/upload-image-temp", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const img = document.createElement("img");
                img.src = "/" + data.path;
                img.classList.add("product-image-thumb");
                preview.appendChild(img);
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
