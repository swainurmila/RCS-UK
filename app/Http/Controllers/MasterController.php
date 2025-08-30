<?php

namespace App\Http\Controllers;
use App\Models\SocietyType;
use App\Models\SocietyObjective;
use App\Models\Inspector;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function showSocietyTypes()
    {
        $societyTypes = SocietyType::get();
        return view('master.societyType.index', compact('societyTypes'));
    }

    public function saveSocietyTypes(Request $request)
    {

        $societyType = SocietyType::create([
            'type' => $request->type,
        ]);

        return response()->json([
            'message' => 'Society type created successfully.',
            'data' => $societyType
        ], 201);
    }

    public function updateSocietyTypes(Request $request, $id)
    {
        $societyType = SocietyType::findOrFail($id);
        $societyType->update([
            'type' => $request->type
        ]);

        return response()->json([
            'message' => 'Society type updated successfully.',
            'data' => $societyType
        ]);
    }

    public function deleteSocietyTypes($id)
    {
        $societyType = SocietyType::findOrFail($id);
        $societyType->delete();

        return response()->json([
            'message' => 'Society type deleted successfully.'
        ]);
    }

    public function showSocietyObjectives()
    {
        $societyObjectives = SocietyObjective::get();
        return view('master.societyObjective.index', compact('societyObjectives'));
    }

    public function saveSocietyObjectives(Request $request)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
        ]);

        $societyObjective = SocietyObjective::create([
            'objective' => $validatedData['type'],
        ]);

        return response()->json([
            'message' => 'Society Objective created successfully.',
            'data' => $societyObjective
        ], 201);
    }

    public function updateSocietyObjectives(Request $request, $id)
    {
        $validatedData = $request->validate([
            'type' => 'required|string|max:255',
        ]);

        $societyObjective = SocietyObjective::findOrFail($id);
        $societyObjective->update([
            'objective' => $validatedData['type'],
        ]);

        return response()->json([
            'message' => 'Society Objective updated successfully.',
            'data' => $societyObjective
        ]);
    }

    public function deleteSocietyObjectives($id)
    {
        $societyObjective = SocietyObjective::findOrFail($id);
        $societyObjective->delete();

        return response()->json([
            'message' => 'Society Objective deleted successfully.'
        ]);
    }

    public function showInspectors()
    {
        $inspectors = Inspector::get();
        return view('master.inspector.index', compact('inspectors'));
    }
    
    public function saveInspectors(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
        ]);
    
        $inspector = Inspector::create([
            'name' => $validatedData['name'],
            'designation' => $validatedData['designation'],
        ]);
    
        return response()->json([
            'message' => 'Inspector created successfully.',
            'data' => $inspector
        ], 201);
    }
    
    public function updateInspectors(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
        ]);
    
        $inspector = Inspector::findOrFail($id);
        $inspector->update([
            'name' => $validatedData['name'],
            'designation' => $validatedData['designation'],
        ]);
    
        return response()->json([
            'message' => 'Inspector updated successfully.',
            'data' => $inspector
        ]);
    }
    
    public function deleteInspectors($id)
    {
        $inspector = Inspector::findOrFail($id);
        $inspector->delete();
    
        return response()->json([
            'message' => 'Inspector deleted successfully.'
        ]);
    }
    
}