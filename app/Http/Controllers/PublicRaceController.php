<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Race;
use App\Models\Category;
use App\Models\Result;
use App\Models\Participant;
use PDF;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Log;

class PublicRaceController extends Controller
{
    public function index()
    {
        $races = Race::all();
        return view('public.races.index', compact('races'));
    }

    public function showCategory(Race $race)
    {
        $categories = Category::where('race_id', $race->id)->orderBy('display_order', 'asc')->get();
        return view('public.races.category', compact('categories'));
    }

    public function showResult(Race $race, Category $category)
    {
        $results = Result::where('category_id', $category->id)
            ->with('block')
            ->orderByRaw("CASE WHEN place = '-' THEN 1 ELSE 0 END, place + 0 ASC")
            ->orderBy('block_id')
            ->get()
            ->groupBy('block_id');

        return view('public.races.result', compact('race', 'category', 'results'));
    }

    public function downloadCertificate(Race $race, Result $result)
    {
        try {
            $template = $race->certificateTemplate;
            if (!$template) {
                return back()->with('error', '記録証テンプレートが設定されていません。');
            }

            $data = [
                'bib_number' => $result->bib,
                'category_name' => $result->category->name,
                'participant_name' => $result->name,
                'finish_time' => $result->time,
                'overall_rank' => $result->place,
                'category_rank' => $result->age_place ?? $result->place,
            ];

            $image_path = public_path('uploads/' . $template->image_path);
            
            if (!file_exists($image_path)) {
                Log::error('テンプレート画像が見つかりません: ' . $image_path);
                return back()->with('error', 'テンプレート画像が見つかりません。');
            }

            $manager = new ImageManager(new Driver());
            $image = $manager->read($image_path);
            
            $maxWidth = 1240;
            $image->scale(width: $maxWidth);
            
            $encodedImage = $image->toPng();
            $image_data = base64_encode($encodedImage);

            $layout_config = $template->layout_config;

            $pdf = PDF::loadView('public.races.certificate', [
                'data' => $data,
                'image_data' => $image_data,
                'layout_config' => $layout_config,
                'template' => $template,
            ])
            ->setPaper(strtolower($template->paper_size), $template->orientation)
            ->setOption('isRemoteEnabled', true)
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isFontSubsettingEnabled', true)
            ->setOption('image-quality', 75);

            $filename = sprintf(
                '%s_%s_%s.pdf',
                $race->name,
                $result->name,
                now()->format('Ymd_His')
            );

            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error('記録証生成エラー: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return back()->with('error', '記録証の生成中にエラーが発生しました。');
        }
    }
}
