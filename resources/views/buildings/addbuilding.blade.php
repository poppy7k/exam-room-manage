<form method="POST" action="{{ route('buildings.store') }}" enctype="multipart/form-data" style="max-width: 400px; margin: 0 auto; padding: 20px; border: 1px solid #ccc; border-radius: 5px;">
    @csrf

    <div style="margin-bottom: 20px;">
        <label for="building_th" style="display: block; font-weight: bold; margin-bottom: 5px;">Building Name (Thai)</label>
        <input type="text" id="building_th" name="building_th" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    </div>

    <div style="margin-bottom: 20px;">
        <label for="building_en" style="display: block; font-weight: bold; margin-bottom: 5px;">Building Name (English)</label>
        <input type="text" id="building_en" name="building_en" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    </div>

    <div style="margin-bottom: 20px;">
        <label for="building_image" style="display: block; font-weight: bold; margin-bottom: 5px;">Upload Picture of Building</label>
        <input type="file" id="building_image" name="building_image" accept="image/*" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    </div>

    <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Next</button>
</form>