<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

    public function showRace(Race $race)
    {
        $categories = $race->categories;
        return view('public.races.show', compact('race', 'categories'));
    }

    public function showCategory(Race $race, Category $category)
    {
        $participants = $category->participants;
        return view('public.races.categories.show', compact('race', 'category', 'participants'));
    }

    public function leaderboard(Race $race, Category $category)
    {
        $results = Result::where('category_id', $category->id)->get()->sort(function ($a, $b) {
            if (in_array($a->place, ['-']) && !in_array($b->place, ['-'])) {
                return 1;
            } elseif (!in_array($a->place, ['-']) && in_array($b->place, ['-'])) {
                return -1;
            } else {
                return $a->place <=> $b->place;
            }
        });
        return view('public.result.leaderboard', compact('category', 'results'));
    }

    public function result()
    {
        // 記録証データを取得
        $category = null;
        $results = null;

        return view('public.result.result', compact('category', 'results'));
    }

}
