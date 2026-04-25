document.addEventListener("DOMContentLoaded", () => {

    const dropzone = document.getElementById("product-dropzone-temp");
    const preview = document.getElementById("temp-images-preview");
    const mainInput = document.getElementById("temp_main_image");

    if (!dropzone || !preview) return;

    const refreshImages = () => {
        fetch("/admin/products/list-temp-images")
            .then(res => res.json())
            .then(data => {
                preview.innerHTML = "";

                data.images.forEach(filename => {
                    const wrapper = document.createElement("div");
                    wrapper.classList.add("product-image-item");

                    const img = document.createElement("img");
                    img.src = "/uploads/tmp/products/" + TEMP_SESSION_ID + "/" + filename;
                    img.classList.add("product-image-thumb");

                    wrapper.appendChild(img);

                    if (data.main === filename) {
                        const badge = document.createElement("div");
                        badge.classList.add("badge-main");
                        badge.textContent = "Główne";
                        wrapper.appendChild(badge);
                    }

                    const btnMain = document.createElement("button");
                    btnMain.classList.add("btn-small");
                    btnMain.textContent = "Ustaw jako główne";
                    btnMain.onclick = () => {
                        fetch("/admin/products/set-temp-main-image", {
                            method: "POST",
                            body: new URLSearchParams({ filename })
                        }).then(() => refreshImages());
                    };
                    wrapper.appendChild(btnMain);

                    const btnDelete = document.createElement("button");
                    btnDelete.classList.add("btn-danger-small");
                    btnDelete.textContent = "Usuń";
                    btnDelete.onclick = () => {
                        fetch("/admin/products/delete-temp-image", {
                            method: "POST",
                            body: new URLSearchParams({ filename })
                        }).then(() => refreshImages());
                    };
                    wrapper.appendChild(btnDelete);

                    preview.appendChild(wrapper);
                });
            });
    };

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
                refreshImages();
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

    refreshImages();
});
