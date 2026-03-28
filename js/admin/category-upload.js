document.addEventListener("DOMContentLoaded", () => {
    const dropzone = document.getElementById("dropzone");
    const previewImg = document.getElementById("preview-img");
    const imagePathInput = document.getElementById("draft_image_path");
    const currentPathInput = document.getElementById("current_image_path");

    const uploadFile = (file) => {
        const formData = new FormData();
        formData.append("file", file);

        const slugInput = document.querySelector("input[name='slug']");
        if (slugInput && slugInput.value) {
            formData.append("slug", slugInput.value);
        }

        // KLUCZOWE: wysyłamy poprzednią ścieżkę
        if (currentPathInput && currentPathInput.value) {
            formData.append("current_path", currentPathInput.value);
        }

        fetch("/admin/categories/upload-image", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                imagePathInput.value = data.path;
                currentPathInput.value = data.path; // aktualizacja
                previewImg.src = "/" + data.path;
                previewImg.style.display = "block";
            } else {
                alert(data.error || "Błąd uploadu");
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
});
