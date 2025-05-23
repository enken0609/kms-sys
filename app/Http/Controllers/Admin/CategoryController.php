<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Race;
use App\Models\Block;
use App\Models\Result;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('race')
            ->orderBy('display_order')
            ->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $races = Race::orderBy('date')->get();
        return view('admin.categories.create', compact('races'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'race_id' => 'required|exists:races,id',
            'is_team_race' => 'boolean',
            'display_order' => 'integer|min:0',
        ]);

        // デフォルト値の設定
        $validated['is_team_race'] = $request->has('is_team_race');
        $validated['display_order'] = $validated['display_order'] ?? 0;

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'カテゴリーが正常に登録されました。');
    }

    public function edit(Category $category)
    {
        $races = Race::orderBy('date')->get();
        return view('admin.categories.edit', compact('category', 'races'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'race_id' => 'required|exists:races,id',
            'is_team_race' => 'boolean',
            'display_order' => 'integer|min:0',
        ]);

        // デフォルト値の設定
        $validated['is_team_race'] = $request->has('is_team_race');
        $validated['display_order'] = $validated['display_order'] ?? 0;

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'カテゴリーが正常に更新されました。');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'カテゴリーが正常に削除されました。');
    }

    public function show(Category $category)
    {
        $blocks = Block::orderBy('display_order')->get();
        $results = Result::where('category_id', $category->id)
            ->with('block')
            ->orderBy('block_id')
            ->orderByRaw("CASE WHEN place = '-' THEN 1 ELSE 0 END, place + 0 ASC")
            ->get();

        return view('admin.categories.show', compact('category', 'blocks', 'results'));
    }

    /**
     * CSVインポート用のサンプルファイルをダウンロード
     */
    public function downloadCsvSample(Category $category)
    {
        $filename = 'result_import_sample_' . str_replace(' ', '_', $category->name) . '.csv';
        
        // CSVヘッダー
        $headers = [
            'place',
            'bib',
            'name',
            'gender',
            'time',
            'age_place',
            'team_name',
            'team_place',
            'team_time'
        ];
        
        // サンプルデータ
        $sampleData = [
            ['1', '101', '山田太郎', 'male', '00:25:30', '1', '', '', ''],
            ['2', '102', '佐藤次郎', 'male', '00:26:15', '1', '', '', ''],
        ];
        
        $callback = function() use ($headers, $sampleData) {
            $file = fopen('php://output', 'w');
            
            // BOM付きUTF-8で出力（Excel対応）
            fputs($file, "\xEF\xBB\xBF");
            
            // ヘッダー行を出力
            fputcsv($file, $headers);
            
            // サンプルデータを出力
            foreach ($sampleData as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function import(Request $request, Category $category)
    {
        $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();
        
        try {
            // ファイルの内容を読み込む
            $content = file_get_contents($path);
            
            // BOMを確認し、UTF-8 with BOMの場合は削除
            if (substr($content, 0, 3) === "\xEF\xBB\xBF") {
                $content = substr($content, 3);
            }
            
            // 文字エンコーディングの検出
            // 日本語特有の文字が含まれる可能性が高い順に検出を試みる
            $encoding = mb_detect_encoding($content, ['SJIS-win', 'SJIS', 'UTF-8', 'EUC-JP'], true);
            
            if ($encoding === false) {
                // エンコーディングの自動検出に失敗した場合、SJISとして処理を試みる
                $encoding = 'SJIS-win';
            }
            
            // UTF-8への変換
            if ($encoding !== 'UTF-8') {
                $content = mb_convert_encoding($content, 'UTF-8', $encoding);
            }
            
            // 一時ファイルに保存
            $tempPath = tempnam(sys_get_temp_dir(), 'csv_');
            file_put_contents($tempPath, $content);
            
            // CSVファイルを読み込む
            $handle = fopen($tempPath, 'r');
            
            // ヘッダー行をスキップ
            $header = fgetcsv($handle);
            
            while (($row = fgetcsv($handle)) !== false) {
                // 空行をスキップ
                if (empty(array_filter($row))) {
                    continue;
                }

                // 各フィールドの前後の空白を削除
                $row = array_map('trim', $row);
                
                // 不正なデータのチェック
                if (count($row) < 5) { // 最低限必要なカラム数
                    continue;
                }

                Result::create([
                    'category_id' => $category->id,
                    'block_id' => $request->block_id,
                    'place' => $row[0],
                    'bib' => $row[1],
                    'name' => $row[2],
                    'gender' => $row[3],
                    'time' => $row[4],
                    'age_place' => isset($row[5]) ? $row[5] : null,
                    'team_name' => isset($row[6]) ? $row[6] : null,
                    'team_place' => isset($row[7]) ? $row[7] : null,
                    'team_time' => isset($row[8]) ? $row[8] : null,
                ]);
            }
            
            fclose($handle);
            unlink($tempPath); // 一時ファイルを削除

            return redirect()
                ->route('admin.categories.show', $category)
                ->with('success', 'リザルトを正常にインポートしました。');

        } catch (\Exception $e) {
            if (isset($handle) && is_resource($handle)) {
                fclose($handle);
            }
            if (isset($tempPath) && file_exists($tempPath)) {
                unlink($tempPath);
            }
            
            \Log::error('CSVインポートエラー: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()
                ->route('admin.categories.show', $category)
                ->with('error', 'インポート中にエラーが発生しました: ' . $e->getMessage());
        }
    }
} 