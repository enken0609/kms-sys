<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TestRaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 最初のレースデータの作成
        $this->createFirstRace();
        
        // 2つ目のレースデータの作成 - トレイルラン大会
        $this->createTrailRunRace();
        
        // 3つ目のレースデータの作成 - マラソン大会
        $this->createMarathonRace();
    }
    
    /**
     * 最初のレースデータを作成
     */
    private function createFirstRace(): void
    {
        // レースデータの作成
        $raceId = DB::table('races')->insertGetId([
            'name' => 'テスト駅伝大会2024',
            'description' => 'これはテスト用のレースデータです。各種機能をテストするために使用されます。',
            'date' => '2024-11-15',
            'series' => 'skyvalley',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // ブロックデータの作成
        $block1Id = DB::table('blocks')->insertGetId([
            'name' => 'Aブロック',
            'display_order' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $block2Id = DB::table('blocks')->insertGetId([
            'name' => 'Bブロック',
            'display_order' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // カテゴリーデータの作成
        $categoryIds = [];

        // 個人カテゴリー
        $categoryIds['individual'] = DB::table('categories')->insertGetId([
            'race_id' => $raceId,
            'name' => '個人',
            'is_team_race' => false,
            'display_order' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // チームカテゴリー
        $categoryIds['team'] = DB::table('categories')->insertGetId([
            'race_id' => $raceId,
            'name' => 'チーム',
            'is_team_race' => true,
            'display_order' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // リザルトデータの作成（個人）
        $individualResults = [
            [
                'category_id' => $categoryIds['individual'],
                'block_id' => $block1Id,
                'place' => '1',
                'bib' => '101',
                'name' => '山田太郎',
                'gender' => '男性',
                'time' => '01:23:45',
                'age_place' => '1',
                'team_name' => '山田チーム',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => $categoryIds['individual'],
                'block_id' => $block1Id,
                'place' => '2',
                'bib' => '102',
                'name' => '佐藤花子',
                'gender' => '女性',
                'time' => '01:25:30',
                'age_place' => '1',
                'team_name' => '佐藤チーム',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => $categoryIds['individual'],
                'block_id' => $block2Id,
                'place' => '3',
                'bib' => '103',
                'name' => '鈴木一郎',
                'gender' => '男性',
                'time' => '01:27:15',
                'age_place' => '2',
                'team_name' => '鈴木チーム',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($individualResults as $result) {
            DB::table('results')->insert($result);
        }

        // リザルトデータの作成（チーム）
        $teamResults = [
            [
                'category_id' => $categoryIds['team'],
                'block_id' => $block1Id,
                'place' => '1',
                'bib' => 'T01',
                'name' => 'チームA代表',
                'gender' => '男性',
                'time' => '04:30:00',
                'team_name' => 'チームA',
                'team_place' => '1',
                'team_time' => '04:30:00',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => $categoryIds['team'],
                'block_id' => $block1Id,
                'place' => '2',
                'bib' => 'T02',
                'name' => 'チームB代表',
                'gender' => '女性',
                'time' => '04:35:20',
                'team_name' => 'チームB',
                'team_place' => '2',
                'team_time' => '04:35:20',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => $categoryIds['team'],
                'block_id' => $block2Id,
                'place' => '3',
                'bib' => 'T03',
                'name' => 'チームC代表',
                'gender' => '男性',
                'time' => '04:40:15',
                'team_name' => 'チームC',
                'team_place' => '3',
                'team_time' => '04:40:15',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($teamResults as $result) {
            DB::table('results')->insert($result);
        }

        // 証明書データの作成
        DB::table('certificates')->insert([
            'id' => $raceId,
            'name' => 'テスト大会完走証',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
    
    /**
     * トレイルランのレースデータを作成
     */
    private function createTrailRunRace(): void
    {
        // レースデータの作成
        $raceId = DB::table('races')->insertGetId([
            'name' => '奥越前トレイルラン2024',
            'description' => '美しい山岳地帯を走るトレイルランニング大会です。初心者から上級者まで楽しめる大会です。',
            'date' => '2024-08-20',
            'series' => 'mountainmarathon',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // カテゴリーデータの作成
        $categoryIds = [];

        // ロングコースカテゴリー
        $categoryIds['long'] = DB::table('categories')->insertGetId([
            'race_id' => $raceId,
            'name' => 'ロングコース (30km)',
            'is_team_race' => false,
            'display_order' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // ショートコースカテゴリー
        $categoryIds['short'] = DB::table('categories')->insertGetId([
            'race_id' => $raceId,
            'name' => 'ショートコース (15km)',
            'is_team_race' => false,
            'display_order' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // ロングコースの結果データ
        $longCourseResults = [
            [
                'category_id' => $categoryIds['long'],
                'place' => '1',
                'bib' => '501',
                'name' => '中村健太',
                'gender' => '男性',
                'time' => '03:12:45',
                'age_place' => '1',
                'team_name' => '山岳会A',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => $categoryIds['long'],
                'place' => '2',
                'bib' => '502',
                'name' => '高橋美咲',
                'gender' => '女性',
                'time' => '03:25:18',
                'age_place' => '1',
                'team_name' => 'トレイルランナーズ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => $categoryIds['long'],
                'place' => '3',
                'bib' => '503',
                'name' => '伊藤誠',
                'gender' => '男性',
                'time' => '03:30:05',
                'age_place' => '2',
                'team_name' => '山岳会B',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($longCourseResults as $result) {
            DB::table('results')->insert($result);
        }

        // ショートコースの結果データ
        $shortCourseResults = [
            [
                'category_id' => $categoryIds['short'],
                'place' => '1',
                'bib' => '601',
                'name' => '斎藤光',
                'gender' => '男性',
                'time' => '01:45:30',
                'age_place' => '1',
                'team_name' => 'ランニングクラブA',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => $categoryIds['short'],
                'place' => '2',
                'bib' => '602',
                'name' => '小林さくら',
                'gender' => '女性',
                'time' => '01:52:10',
                'age_place' => '1',
                'team_name' => 'ジョガーズ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($shortCourseResults as $result) {
            DB::table('results')->insert($result);
        }

        // 証明書データの作成
        DB::table('certificates')->insert([
            'id' => $raceId,
            'name' => 'トレイルラン完走証',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
    
    /**
     * マラソン大会のレースデータを作成
     */
    private function createMarathonRace(): void
    {
        // レースデータの作成
        $raceId = DB::table('races')->insertGetId([
            'name' => '東京湾岸マラソン2024',
            'description' => '東京湾の美しい景色を眺めながら走る都市型マラソン大会です。',
            'date' => '2024-12-05',
            'series' => 'shirane',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // カテゴリーデータの作成
        $categoryIds = [];

        // フルマラソンカテゴリー
        $categoryIds['full'] = DB::table('categories')->insertGetId([
            'race_id' => $raceId,
            'name' => 'フルマラソン (42.195km)',
            'is_team_race' => false,
            'display_order' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // ハーフマラソンカテゴリー
        $categoryIds['half'] = DB::table('categories')->insertGetId([
            'race_id' => $raceId,
            'name' => 'ハーフマラソン (21.0975km)',
            'is_team_race' => false,
            'display_order' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // 10kmカテゴリー
        $categoryIds['10k'] = DB::table('categories')->insertGetId([
            'race_id' => $raceId,
            'name' => '10kmラン',
            'is_team_race' => false,
            'display_order' => 3,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // フルマラソンの結果データ
        $fullMarathonResults = [
            [
                'category_id' => $categoryIds['full'],
                'place' => '1',
                'bib' => '1001',
                'name' => '田中勇気',
                'gender' => '男性',
                'time' => '02:35:42',
                'age_place' => '1',
                'team_name' => '市民ランナーズ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => $categoryIds['full'],
                'place' => '2',
                'bib' => '1002',
                'name' => '佐々木真美',
                'gender' => '女性',
                'time' => '02:50:18',
                'age_place' => '1',
                'team_name' => 'アスリートクラブ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($fullMarathonResults as $result) {
            DB::table('results')->insert($result);
        }

        // ハーフマラソンの結果データ
        $halfMarathonResults = [
            [
                'category_id' => $categoryIds['half'],
                'place' => '1',
                'bib' => '2001',
                'name' => '渡辺裕太',
                'gender' => '男性',
                'time' => '01:10:25',
                'age_place' => '1',
                'team_name' => 'ハリアーズ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => $categoryIds['half'],
                'place' => '2',
                'bib' => '2002',
                'name' => '松本恵',
                'gender' => '女性',
                'time' => '01:18:32',
                'age_place' => '1',
                'team_name' => 'ランニングラボ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($halfMarathonResults as $result) {
            DB::table('results')->insert($result);
        }

        // 10kmの結果データ
        $tenKResults = [
            [
                'category_id' => $categoryIds['10k'],
                'place' => '1',
                'bib' => '3001',
                'name' => '加藤拓也',
                'gender' => '男性',
                'time' => '00:32:15',
                'age_place' => '1',
                'team_name' => 'スピードスターズ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'category_id' => $categoryIds['10k'],
                'place' => '2',
                'bib' => '3002',
                'name' => '山本優子',
                'gender' => '女性',
                'time' => '00:35:48',
                'age_place' => '1',
                'team_name' => 'ジョイランナーズ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($tenKResults as $result) {
            DB::table('results')->insert($result);
        }

        // 証明書データの作成
        DB::table('certificates')->insert([
            'id' => $raceId,
            'name' => '東京湾岸マラソン完走証',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
} 