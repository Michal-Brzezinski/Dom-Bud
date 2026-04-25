document.addEventListener("DOMContentLoaded", () => {

    const dropzone         = document.getElementById("dropzone");
    const previewImg       = document.getElementById("preview-img");
    const imagePathInput   = document.getElementById("draft_image_path");
    const currentPathInput = document.getElementById("current_image_path");
    const removeBtn        = document.getElementById("remove-image-btn");

    // Jeśli nie ma dropzone → nic nie rób
    if (!dropzone) return;

    const uploadFile = (file) => {
        if (!file) return;

        const formData = new FormData();
        formData.append("image", file);

        const slugInput = document.querySelector("input[name='slug']");
        if (slugInput && slugInput.value) {
            formData.append("slug", slugInput.value);
        }

        if (currentPathInput && currentPathInput.value) {
            formData.append("current_path", currentPathInput.value);
        }

        fetch("/admin/categories/upload-image", {
            method: "POST",
            body: formData
        })
        .then(async (res) => {
            const data = await res.json().catch(() => ({}));

            if (!res.ok) {
                throw new Error(data.error || "Błąd serwera");
            }

            return data;
        })
        .then((data) => {
            if (data.success) {

                if (imagePathInput) imagePathInput.value = data.path;
                if (currentPathInput) currentPathInput.value = data.path;

                if (previewImg) {
                    previewImg.src = "/" + data.path;
                    previewImg.style.display = "block";
                }

                if (removeBtn) {
                    removeBtn.style.display = "inline-block";
                }

            } else {
                alert(data.error || "Błąd uploadu");
            }
        })
        .catch((err) => {
            console.error("Upload error:", err);
            alert(err.message || "Błąd uploadu");
        });
    };

    dropzone.addEventListener("click", () => {
        const input = document.createElement("input");
        input.type = "file";
        input.accept = "image/*";

        input.onchange = () => {
            if (input.files.length > 0) {
                uploadFile(input.files[0]);
            }
        };

        input.click();
    });

    dropzone.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropzone.classList.add("dragover");
    });

    dropzone.addEventListener("dragleave", () => {
        dropzone.classList.remove("dragover");
    });

    dropzone.addEventListener("drop", (e) => {
        e.preventDefault();
        dropzone.classList.remove("dragover");

        const file = e.dataTransfer.files[0];
        if (file) uploadFile(file);
    });

    if (removeBtn) {
        removeBtn.addEventListener("click", () => {
            if (previewImg) {
                previewImg.src = "";
                previewImg.style.display = "none";
            }

            if (imagePathInput) imagePathInput.value = "";
            if (currentPathInput) currentPathInput.value = "";

            removeBtn.style.display = "none";
        });
    }
});
