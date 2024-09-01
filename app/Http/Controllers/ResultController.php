<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RACE;
use App\Models\Category;
use App\Models\Result;
use PDF;

class ResultController extends Controller
{
    public function index(Category $category)
    {
        $results = $category->results()->orderBy('place')->get();
        return view('public.result.index', compact('category', 'results'));
    }

    // public function leaderboard(Race $race, Category $category)
    // {
    //     $results = Result::where('category_id', $category->id)->get()->sort(function ($a, $b) {
    //         if (in_array($a->place, ['-']) && !in_array($b->place, ['-'])) {
    //             return 1;
    //         } elseif (!in_array($a->place, ['-']) && in_array($b->place, ['-'])) {
    //             return -1;
    //         } else {
    //             return $a->place <=> $b->place;
    //         }
    //     });
    //     return view('public.result.leaderboard', compact('category', 'results'));
    // }

    public function result(Category $category, Result $result)
    {
        $race_id= 3;
        $results = Result::where('category_id', $category->id)->get()->sort(function ($a, $b) {
            if (in_array($a->place, ['-']) && !in_array($b->place, ['-'])) {
                return 1;
            } elseif (!in_array($a->place, ['-']) && in_array($b->place, ['-'])) {
                return -1;
            } else {
                return $a->place <=> $b->place;
            }
        });
        return view('public.result.index', compact('category', 'results'));
    }

    public function downloadCertificate(Category $category, Result $result)
    {
        // 完走証のPDF生成とダウンロード処理
        // ここにPDF生成のロジックを追加します
        $data = [
            'bib' => $result->bib,
            'category' => $category->name,
            'name' => $result->name,
            'time' => $result->time,
            'rank' => $result->place,
        ];

        $pdf = PDF::loadView('public.result.certificate', $data);
        // $pdf = PDF::loadView('public.result.certificate', $data)
        //     ->setPaper('b5', 'portrait') // 用紙サイズと向きを設定
        //     ->setOptions([
        //         'isHtml5ParserEnabled' => true,
        //         'isRemoteEnabled' => true,
        //     ]);

        // return view('public.result.certificate', compact('data'));

        return $pdf->setPaper('b5')->download('certificate.pdf');
    }
}
