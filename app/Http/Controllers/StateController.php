<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::all();
        return view('dashboard', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'iso' => 'required',
        ]);

        $validatedData['name'] = ucfirst($validatedData['name']);
        $validatedData['iso'] = strtoupper($validatedData['iso']);
        $validatedData['user_id'] = auth()->id();

        State::create($validatedData);

        return redirect()->route('dashboard')->with('success', 'State created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        return view('show', compact('state'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        return view('edit', compact('state'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'iso' => 'required|string|max:255',
        ]);

        // Find the state by ID
        $state = State::findOrFail($id);

        // Update the state record in the database
        $state->name = ucfirst($validatedData['name']);
        $state->iso = strtoupper($validatedData['iso']);
        $state->save();

        // Return a response indicating the success or any other relevant information
        return response()->json([
            'message' => 'State updated successfully',
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state): JsonResponse
    {
        $state->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
