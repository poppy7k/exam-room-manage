<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\SelectedRoom;
use Illuminate\Support\Facades\Log;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = Staff::all();
        return response()->json($staffs);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function saveStaffs(Request $request)
    {
        try {
            // Log::info('Received request to save staffs', ['room_id' => $request->input('room_id'), 'examiners' => $request->input('examiners')]);
    
            $roomId = $request->input('room_id');
            $examiners = $request->input('examiners');
    
            $selectedRoom = SelectedRoom::where('room_id', $roomId)->first();
    
            $oldStaffs = Staff::where('selected_room_id', $selectedRoom->id)->get();
    
            foreach ($oldStaffs as $oldStaff) {
                $oldStaff->selected_room_id = null;
                $oldStaff->save();
            }
    
            foreach ($examiners as $examiner) {
                $staff = Staff::find($examiner['id']);
                if ($staff) {
                    $staff->selected_room_id = $selectedRoom->id;
                    $staff->save();
                }
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json(['success' => false, 'message' => 'Validation failed.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error saving staff: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Failed to save staff.'], 500);
        }
    }
    
    
    
    
    
    
}
