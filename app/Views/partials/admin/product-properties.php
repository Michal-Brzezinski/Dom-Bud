<div class="properties-editor">

    <div id="properties-list"></div>

    <button type="button" class="btn" id="add-property-btn">
        + Dodaj właściwość
    </button>

    <!-- tu trzymamy JSON -->
    <input type="hidden" name="properties" id="properties-json" value='<?= $propertiesJson ?? "{}" ?>'>

</div>

<script src="<?= asset('js/admin/product-properties.js') ?>"></script>