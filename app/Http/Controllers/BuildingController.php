<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'building_th' => 'required|string',
            'building_en' => 'required|string',
            'building_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($request->hasFile('building_image')) {
            $imagePath = $request->file('building_image')->store('building_images', 'public');
        } else {
            
            $imagePath = null; 
        }
    
        Building::create([
            'building_th' => $validatedData['building_th'],
            'building_en' => $validatedData['building_en'],
            'building_image' => $imagePath,
        ]);
    
        return redirect()->back()->with('success', 'Building information has been saved.');
    }
}
