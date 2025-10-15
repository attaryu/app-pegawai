<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::withCount('employees')->latest()->paginate(10);

        return view('positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'gaji_pokok' => 'nullable|string',
        ]);

        Position::create($request->only('nama_jabatan', 'gaji_pokok'));

        return redirect()->route('positions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $position = Position::with('employees.department')->find($id);

        return view('positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $position = Position::find($id);

        return view('positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'gaji_pokok' => 'nullable|string',
        ]);

        $position = Position::find($id);
        $position->update($request->only('nama_jabatan', 'gaji_pokok'));

        return redirect()->route('positions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $position = Position::find($id);
        $position->delete();

        return redirect()->route('positions.index');
    }
}
