<?php
// --- BEZPIECZNE WARTOŚCI DOMYŚLNE ---
$draftImage = $category->draft_image_path ?? null;
$publishedImage = $category->image_path ?? null;

// obraz do wyświetlenia
$currentImage = $draftImage ?: $publishedImage;
?>

<div class="image-upload">
    <label>Obraz kategorii:</label>

    <div id="dropzone" class="dropzone">
        Przeciągnij obraz tutaj lub kliknij, aby wybrać
    </div>

    <!-- ścieżka szkicu (lub opublikowana, jeśli brak szkicu) -->
    <input type="hidden"
        name="draft_image_path"
        id="draft_image_path"
        value="<?= e($currentImage) ?>">

    <!-- potrzebne do usuwania starego pliku -->
    <input type="hidden"
        id="current_image_path"
        value="<?= e($currentImage) ?>">

    <div class="preview">
        <img
            id="preview-img"
            src="<?= $currentImage ? asset($currentImage) : '' ?>"
            style="<?= $currentImage ? '' : 'display:none;' ?>">
    </div>
</div>