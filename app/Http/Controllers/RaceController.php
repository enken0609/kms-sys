<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Race;

class RaceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $races = Race::all();
        return view('admin.race.list', compact('races'));
    }

    public function create()
    {
        return view('admin.race.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'date' => 'required|date',
        ]);

        Race::create($request->all());

        return redirect()->route('admin.race.list')->with('success', 'Race created successfully.');
    }

    public function edit(Race $race)
    {
        return view('admin.race.edit', compact('race'));
    }

    public function update(Request $request, Race $race)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'date' => 'required|date',
        ]);

        $race->update($request->all());

        return redirect()->route('admin.race.list')->with('success', 'Race updated successfully.');
    }

    public function destroy(Race $race)
    {
        $race->delete();

        return redirect()->route('admin.race.list')->with('success', 'Race deleted successfully.');
    }
}
