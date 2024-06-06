<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Buildings</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 0; display: flex; flex-direction: column; align-items: center;">
    <h1 style="text-align: center; margin: 20px 0; color: #333;">List of Buildings</h1>

    <div class="add-building" style="margin: 20px 0; width: 80%; max-width: 600px; display: flex; justify-content: flex-end;">
        <a href="{{ route('buildings.addbuilding') }}" style="background-color: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; transition: background-color 0.3s ease;">Add Building</a>
    </div>

    <ul style="list-style-type: none; padding: 0; width: 80%; max-width: 600px; margin: 0;">
        @foreach ($buildings as $building)
            <li style="background: #ffffff; margin: 10px 0; padding: 10px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">{{ $building->building_th }} ({{ $building->building_en }})</li>
        @endforeach
    </ul>
</body>
</html>