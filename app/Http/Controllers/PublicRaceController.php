<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Race;
use App\Models\Category;
use App\Models\Result;
use App\Models\Participant;
use PDF;

class PublicRaceController extends Controller
{
    public function index()
    {
        $races = Race::all();
        return view('public.races.index', compact('races'));
    }

    public function showCategory(Race $race)
    {
        // race_id が $race->id に一致する Category をすべて取得
        $categories = Category::where('race_id', $race->id)->orderBy('display_order', 'asc')->get();

        return view('public.races.category', compact('categories'));
    }

    public function showResult(Race $race, Category $category)
    {

        $results = Result::where('category_id', $category->id)
            ->with('block')
            ->orderByRaw("CASE WHEN place = '-' THEN 1 ELSE 0 END, place + 0 ASC")
            ->orderBy('block_id') // block_idごとに並べる
            ->get()
            ->groupBy('block_id'); // block_idごとにグループ化


        // // 男子総合リザルト resultモデルからrace_idが$race->i、、genderがMaleのものをplaceの昇順で取得
        // $maleResults = Result::where('category_id', $category->id)
        //     ->where('gender', 'Male')
        //     ->orderByRaw("CASE WHEN place = '-' THEN 1 ELSE 0 END, place + 0 ASC")
        //     ->orderBy('place', 'asc')
        //     ->get();

        // // // 女子総合リザルト resultモデルからrace_idが$race->i、、genderがFemaleのものをplaceの昇順で取得
        // $femaleResults = Result::where('category_id', $category->id)
        //     ->where('gender', 'Female')
        //     ->orderByRaw("CASE WHEN place = '-' THEN 1 ELSE 0 END, place + 0 ASC")
        //     ->orderBy('bib', 'asc')
        //     ->get();

        return view('public.races.result', compact('race', 'category', 'results'));
    }

    public function downloadCertificate(Race $race, Result $result)
    {
        // レースに紐づくテンプレートを取得
        $template = $race->certificateTemplate;
        if (!$template) {
            return back()->with('error', '記録証テンプレートが設定されていません。');
        }

        // 完走証のデータ準備
        $data = [
            'bib_number' => $result->bib,
            'category_name' => $result->category->name,
            'participant_name' => $result->name,
            'finish_time' => $result->time,
            'overall_rank' => $result->place,
            'category_rank' => $result->category_place ?? $result->place,
        ];

        // テンプレート画像の取得
        $image_path = Storage::disk('public')->path($template->image_path);
        $image_data = base64_encode(file_get_contents($image_path));

        // レイアウト設定の取得
        $layout_config = $template->layout_config;

        // PDFの生成
        $pdf = PDF::loadView('public.races.certificate', [
            'data' => $data,
            'image_data' => $image_data,
            'layout_config' => $layout_config,
            'template' => $template,
        ])->setPaper(strtolower($template->paper_size), $template->orientation);

        // ファイル名の設定
        $filename = sprintf(
            '%s_%s_%s.pdf',
            $race->name,
            $result->name,
            now()->format('Ymd_His')
        );

        return $pdf->download($filename);
    }
}
