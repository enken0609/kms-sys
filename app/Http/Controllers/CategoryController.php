<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Race;
use App\Models\Category;
use App\Models\Result;
use App\Models\Entry;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use PDF;

class CategoryController extends Controller
{
    public function index(Race $race)
    {
        $categories = $race->categories;
        return view('admin.category.index', compact('race', 'categories'));
    }

    public function create(Race $race)
    {
        return view('admin.category.create', compact('race'));
    }

    public function store(Request $request, Race $race)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'webscorer_race_id' => 'required|integer',
        ]);

        $race->categories()->create($request->only(['name', 'status', 'webscorer_race_id']));

        return redirect()->route('admin.category.index', $race->id)->with('success', 'Category created successfully.');
    }

    public function edit(Race $race, Category $category)
    {
        return view('admin.category.edit', compact('race', 'category'));
    }

    public function update(Request $request, Race $race, Category $category)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'webscorer_race_id' => 'required|integer',
        ]);

        $category->update($request->only(['name', 'status', 'webscorer_race_id']));

        return redirect()->route('admin.category.index', $race->id)->with('success', 'Category updated successfully.');
    }

    public function destroy(Race $race, Category $category)
    {
        $category->delete();

        return redirect()->route('admin.category.index', $race->id)->with('success', 'Category deleted successfully.');
    }

    public function updateResults(Request $request, $race_id, Category $category)
    {
        $api_id = env('WEBS_CORER_API_ID'); // .envファイルに設定する予定のapi_id

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36'
            ])->get("https://www.webscorer.com/json/race", [
                'raceid' => $category->webscorer_race_id,
                'apiid' => $api_id
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $ResultList = $data['Results'];

                DB::beginTransaction();

                try {

                    foreach ($ResultList as $result) {
                        if (isset($result['Grouping']['Category'])) {
                            if (str_replace('　', ' ', $result['Grouping']['Category']) === str_replace('　', ' ', $category->name)) {
                                $updateRacers = $result['Racers'];
                            }
                        } else {
                            $updateRacers = $result['Racers'];
                        }
                    }

                    if (isset($updateRacers)) {
                        foreach ($updateRacers as $updateRacer) {
                            Result::updateOrCreate(
                                ['bib' => $updateRacer['Bib'], 'category_id' => $category->id],
                                [
                                    'category_id' => $category->id,
                                    'place' => $updateRacer['Place'],
                                    'name' => $updateRacer['Name'],
                                    'team_name' => $updateRacer['TeamName'],
                                    'age' => $updateRacer['Age'],
                                    'gender' => $updateRacer['Gender'],
                                    'time' => $updateRacer['Time'],
                                    'difference' => $updateRacer['Difference'],
                                    'start_time' => $updateRacer['StartTime'],
                                ]
                            );
                        }
                    }

                    // dd($updateRacer);
                    DB::commit();


                    return redirect()->route('admin.category.index', $race_id)->with('success', 'Results updated successfully.');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return redirect()->route('admin.category.index', $race_id)->with('error', 'Failed to update results: ' . $e->getMessage());
                }
            } else {
                return redirect()->route('admin.category.index', $race_id)->with('error', 'Failed to fetch results from API.');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.category.index', $race_id)->with('error', 'Error occurred: ' . $e->getMessage());
        }
    }

    // public function result(Race $race, Category $category)
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
    //     return view('admin.category.result', compact('category', 'results'));
    // }

    public function result(Request $request, Race $race, Category $category, Result $result)
    {
        $bib = $request->input('bib');
        $bibSearchResult = null;

        if ($bib) {
            $bibSearchResult = $category->results()->where('bib', $bib)->first();
        }

        // リザルトデータ取得、placeが"-"のものは末尾に並び替える
        $results = Result::where('category_id', $category->id)->get()->sortBy(function ($result) {
            return $result->place === '-' ? PHP_INT_MAX : (int)$result->place;
        });

        // Entryモデルからbibで検索してEntryデータからkanaとaward_categoryを取得して配列に再格納する

        $searchResults = [];
        $raceId = $race->id;
        foreach ($results as $result) {
            $entry = Entry::where('bib_number', $result->bib)->where('race_id', $raceId)->first();
            if ($entry) {
                $searchResults[] = [
                    'id' => $result->id,
                    'category_id' => $result->category_id,
                    'place' => $result->place,
                    'bib' => $result->bib,
                    'name' => $result->name,
                    'team_name' => $result->team_name,
                    'age' => $result->age,
                    'gender' => $result->gender,
                    'time' => $result->time,
                    'difference' => $result->difference,
                    'start_time' => $result->start_tim,
                    'kana' => $entry->name_kana,
                    'award_category' => $entry->award_category,
                    'overall_count' => count($results),
                    'category' => $category->name,
                ];
            }
        }

        // 総合5位以内は除外
        $top5ExclusionResults = array_filter($searchResults, function ($result) {
            return !in_array($result['place'], ["1", "2", "3", "4", "5"]);
        });

        // 表彰対象のデータだけに絞る
        $filteredResults = array_filter($top5ExclusionResults, function ($result) {
            return !empty($result['award_category']);
        });


        // 表彰対象のグループごとに配列を作成
        $groupedResults = [];
        foreach ($filteredResults as $result) {
            $groupedResults[$result['award_category']][] = $result;
        }

        // グループごとの順位付け
        foreach ($groupedResults as $awardCategory => &$group) {
            usort($group, function ($a, $b) {
                return $a['place'] === '-' ? 1 : ($b['place'] === '-' ? -1 : $a['place'] - $b['place']);
            });

            $award_place_count = count($group);
            foreach ($group as $index => &$result) {
                if ($result['place'] !== '-') {
                    $result['award_place'] = $index + 1;
                } else {
                    $result['award_place'] = "-";
                }
                $result['award_place_count'] = $award_place_count;
            }
        }
        // dd($groupedResults);
        // // グループごとの順位付け
        // foreach ($groupedResults as $awardCategory => &$group) {
        //     usort($group, function ($a, $b) {
        //         return strcmp($a['time'], $b['time']);
        //     });
        //     foreach ($group as $index => &$result) {
        //         $result['award_place'] = $index + 1;
        //         $result['award_place_count'] = count($group);
        //     }
        // }

        // 総合順位はそのままの順位で項目を作成
        $overallResults = [];
        foreach ($searchResults as $searchResult) {
            $searchResult['award_place'] = $searchResult['place'];
            $searchResult['award_target'] = 0;
            $searchResult['award_place_count'] = "-";
            $overallResults[] = $searchResult;
        }
        $groupedResults['総合'] = $overallResults;

        // dd($groupedResults);

        // if (count($groupedResults) > 1) {
        // 各グループ内でソートと順位の付与
        // foreach ($groupedResults as $award_category => &$group) {
        //     usort($group, function ($a, $b) {
        //         return strcmp($a['time'], $b['time']);
        //     });
        //     foreach ($group as $index => &$result) {
        //         $result['award_place'] = $index + 1;
        //     }
        // }
        // }


        // キーを昇順で並び替え、"総合"を先頭に固定
        uksort($groupedResults, function ($a, $b) {
            if ($a === '総合') return -1;
            if ($b === '総合') return 1;
            return strcmp($a, $b);
        });

        $bibResult = null;
        if ($bib) {
            foreach ($groupedResults as $groupedResult) {
                foreach ($groupedResult as $result) {
                    if ($result['bib'] == $bibSearchResult->bib) {
                        $bibResult = $result;
                    }
                }
            }
        }
        // dd($groupedResults);
        return view('admin.category.result', compact('category', 'results', 'race', 'bibResult', 'groupedResults'));
    }

    public function downloadCertificate(Race $race, Category $category, Result $result, $award_place, $award_place_count, $overall_count)
    {
        // カテゴリーの参加者数を取得
        $categoryCount = Result::where('category_id', $category->id)->count();

        $data = [
            'bib' => $result->bib,
            'category' => $category->name,
            'name' => $result->name,
            'time' => $result->time,
            'rank' => $result->place,
            'awardPlace' => $award_place,
            'awardPlaceCount' => $award_place_count,
            'overallCount' => $overall_count,
        ];

        $pdf = PDF::loadView('admin.category.certificate', $data);

        return $pdf->stream('certificate.pdf');
    }

    public function manualPrintForm()
    {
        return view('admin.category.manual_print_form');
    }

    public function manualPrint(Request $request)
    {
        $data = $request->validate([
            'category' => 'required|string',
            'rank' => 'required|string',
            'name' => 'required|string',
            'time' => 'required|string',
        ]);

        $pdf = PDF::loadView('admin.category.award_manual', $data);

        return $pdf->stream('certificate.pdf');
    }

    public function autoPrint(Request $request)
    {
        $data = $request->only(['name', 'age', 'bib', 'name', 'kana', 'time', 'award_place', 'place', 'category']);
        $pdf = PDF::loadView('admin.category.award_auto', $data);

        return $pdf->stream('certificate.pdf');
    }
}
