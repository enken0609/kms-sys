<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\EntryImport;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use App\Models\Race;

class EntryImportController extends Controller
{
    public function showImportForm(Race $race)
    {
        return view('admin.entry.import', compact('race'));
    }

    public function import(Request $request, Race $race)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new EntryImport($race->id), $request->file('file'));
            return redirect()->route('admin.entry.index', $race->id)->with('success', 'Entries imported successfully.');
        } catch (Exception $e) {
            return redirect()->route('admin.entry.import.form', $race->id)->with('error', 'Error importing entries: ' . $e->getMessage());
        }
    }
}
