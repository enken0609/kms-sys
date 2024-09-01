<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;
use App\Models\Race;

class EntryController extends Controller
{
    public function index(Race $race)
    {
        $entries = $race->entries;
        return view('admin.entry.index', compact('race', 'entries'));
    }

    public function create(Race $race)
    {
        return view('admin.entry.create', compact('race'));
    }

    public function store(Request $request, Race $race)
    {
        $request->validate([
            'name' => 'required',
            'name_kana' => 'required',
            'gender' => 'required',
            'age' => 'integer',
            'team_name' => 'nullable',
            'start_time' => 'required|date_format:H:i:s',
            'bib_number' => 'required|unique:entries,bib_number',
            'category' => 'required',
            'award_category' => 'nullable',
        ]);

        $race->entries()->create($request->only([
            'name', 'name_kana', 'gender', 'age', 'team_name', 'start_time', 'bib_number', 'category'
        ]));

        return redirect()->route('admin.entry.index', $race->id)->with('success', 'Entry created successfully.');
    }

    public function edit(Race $race, Entry $entry)
    {
        return view('admin.entry.edit', compact('race', 'entry'));
    }

    public function update(Request $request, Race $race, Entry $entry)
    {
        $request->validate([
            'name' => 'required',
            'name_kana' => 'required',
            'gender' => 'required',
            'age' => 'required|integer',
            'team_name' => 'nullable',
            'start_time' => 'required|date_format:H:i:s',
            'bib_number' => 'required|unique:entries,bib_number,' . $entry->id,
            'category' => 'required',
            'award_category' => 'required',
        ]);

        $entry->update($request->only([
            'name', 'name_kana', 'gender', 'age', 'team_name', 'start_time', 'bib_number', 'category'
        ]));

        return redirect()->route('admin.entry.index', $race->id)->with('success', 'Entry updated successfully.');
    }

    public function destroy(Race $race, Entry $entry)
    {
        $entry->delete();

        return redirect()->route('admin.entry.index', $race->id)->with('success', 'Entry deleted successfully.');
    }
}
