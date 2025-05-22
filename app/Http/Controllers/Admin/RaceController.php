<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Race;
use Illuminate\Support\Facades\Storage;
use App\Models\CertificateTemplate;

class RaceController extends Controller
{
    public function index()
    {
        $races = Race::latest()->paginate(10);
        return view('admin.races.index', compact('races'));
    }

    public function create()
    {
        $seriesOptions = Race::SERIES_OPTIONS;
        $certificateTemplates = CertificateTemplate::orderBy('name')->get();
        return view('admin.races.create', compact('seriesOptions', 'certificateTemplates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
            'series' => 'required|string|in:' . implode(',', array_keys(Race::SERIES_OPTIONS)),
            'certificate_template_id' => 'nullable|exists:certificate_templates,id',
        ]);

        Race::create($validated);

        return redirect()->route('admin.races.index')
            ->with('success', 'レースが正常に登録されました。');
    }

    public function edit(Race $race)
    {
        $seriesOptions = Race::SERIES_OPTIONS;
        $certificateTemplates = CertificateTemplate::orderBy('name')->get();
        return view('admin.races.edit', compact('race', 'seriesOptions', 'certificateTemplates'));
    }

    public function update(Request $request, Race $race)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
            'series' => 'required|string|in:' . implode(',', array_keys(Race::SERIES_OPTIONS)),
            'certificate_template_id' => 'nullable|exists:certificate_templates,id',
        ]);

        $race->update($validated);

        return redirect()->route('admin.races.index')
            ->with('success', 'レースが正常に更新されました。');
    }

    public function destroy(Race $race)
    {
        $race->delete();

        return redirect()->route('admin.races.index')
            ->with('success', 'レースが正常に削除されました。');
    }

    public function import(Request $request, Race $race)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $path = $file->store('temp');
        
        // CSVの処理ロジックを実装
        // TODO: CSVのパースとリザルトの保存処理を実装

        return redirect()
            ->route('admin.races.show', $race)
            ->with('success', 'リザルトをインポートしました。');
    }
} 