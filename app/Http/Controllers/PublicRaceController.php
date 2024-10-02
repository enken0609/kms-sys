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
        // 完走証のPDF生成とダウンロード処理
        $data = [
            'bib' => $result->bib,
            'category' => $result->category->name,
            'name' => $result->name,
            'team_name' => $result->team_name,
            'time' => $result->time,
            'team_time' => $result->team_time,
            'place' => $result->place,
            'team_place' => $result->team_place,
        ];

        $image_path = null;
        $series = $race->series;
        if ($series == 'skyvalley') {
            $image_path = public_path('img/skyvalley_certificate_template.png');
        } elseif ($series == 'shirane') {
            $image_path = public_path('img/shirane_certificate_template.png');
        }

        $image_data = base64_encode(file_get_contents($image_path));

        if ($series == 'skyvalley') {
            $pdf = PDF::loadView('public.races.certificate', compact('data', 'image_data'))->setPaper('b5', 'portrait');
        } elseif ($series == 'shirane') {
            $is_team_race = $result->category->is_team_race;
            if ($is_team_race == 1) {
                $pdf = PDF::loadView('public.races.shirane_team_certificate', compact('data', 'image_data'))->setPaper('b5', 'portrait');
            } else {
                $pdf = PDF::loadView('public.races.shirane_certificate', compact('data', 'image_data'))->setPaper('b5', 'portrait');
            }
        }

        return $pdf->setPaper('b5')->download('certificate.pdf');
        // $pdf->download('certificate.pdf');

        // $pdf = PDF::loadView('public.races.certificate', $data)
        //     ->setPaper('b5', 'portrait') // 用紙サイズと向きを設定
        //     ->setOptions([
        //         'isHtml5ParserEnabled' => true,
        //         'isRemoteEnabled' => true,
        //     ]);

        // $pdf = PDF::loadView('public.races.certificate', $data);

        // return $pdf->stream('certificate.pdf');

        // return view('public.races.certificate', compact('data'));

    }
}
