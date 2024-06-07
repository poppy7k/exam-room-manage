<form method="POST" action="{{ route('buildings.store') }}" enctype="multipart/form-data" style="max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;" onsubmit="return validateForm()">
    @csrf

    <div style="margin-bottom: 20px;">
        <label for="building_th" style="display: block; font-weight: bold; margin-bottom: 5px;">Building Name (Thai)</label>
        <input type="text" id="building_th" name="building_th" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        <span id="building_th_error" class="error-message" style="color: red; display: none;">Building Name (Thai) can only contain Thai alphabet and numbers.</span>
    </div>

    <div style="margin-bottom: 20px;">
        <label for="building_en" style="display: block; font-weight: bold; margin-bottom: 5px;">Building Name (English)</label>
        <input type="text" id="building_en" name="building_en" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
        <span id="building_en_error" class="error-message" style="color: red; display: none;">Building Name (English) can only contain English alphabet and numbers.</span>
    </div>

    <div style="margin-bottom: 20px;">
        <label for="building_image" style="display: block; font-weight: bold; margin-bottom: 5px;">Upload Picture of Building</label>
        <input type="file" id="building_image" name="building_image" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    </div>

    <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Next</button>
</form>

<script>
function validateForm() {
    var isValid = true;

    var buildingTh = document.getElementById('building_th').value;
    var buildingEn = document.getElementById('building_en').value;

    var thaiPattern = /^[ก-๙0-9]+$/;
    var englishPattern = /^[A-Za-z0-9]+$/;

    var buildingThError = document.getElementById('building_th_error');
    var buildingEnError = document.getElementById('building_en_error');

    if (!thaiPattern.test(buildingTh)) {
        buildingThError.style.display = 'block';
        isValid = false;
    } else {
        buildingThError.style.display = 'none';
    }

    if (!englishPattern.test(buildingEn)) {
        buildingEnError.style.display = 'block';
        isValid = false;
    } else {
        buildingEnError.style.display = 'none';
    }

    return isValid;
}
</script>