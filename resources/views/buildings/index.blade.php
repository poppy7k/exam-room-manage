<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Buildings</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0; display: flex; flex-direction: column; align-items: center;">
    <h1 style="text-align: center; margin: 20px 0; color: #333;">List of Buildings</h1>

    <div class="search-container" style="width: 80%; max-width: 600px; margin-bottom: 20px;">
        <input type="text" id="search-input" placeholder="Search by building name..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    </div>

    <div class="add-building" style="margin-bottom: 20px; width: 80%; max-width: 600px; display: flex; justify-content: flex-end;">
        <a href="{{ route('pages.building-create') }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; transition: background-color 0.3s ease;">Add Building</a>
    </div>

    <ul id="building-list" style="list-style-type: none; padding: 0; width: 80%; max-width: 600px; margin: 0;">
        @foreach ($buildings as $building)
            <li class="building-item" style="background: #ffffff; margin: 10px 0; padding: 10px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">{{ $building->building_th }} ({{ $building->building_en }})</li>
        @endforeach
    </ul>

    <script>
        document.getElementById('search-input').addEventListener('input', function() {
            var searchQuery = this.value.toLowerCase();
            var buildingItems = document.getElementsByClassName('building-item');

            Array.from(buildingItems).forEach(function(item) {
                var buildingName = item.textContent.toLowerCase();
                if (buildingName.includes(searchQuery)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>