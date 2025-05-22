# データベース設計

## テーブル構造

### certificate_templates
記録証のテンプレート情報を管理するテーブル

| カラム名 | 型 | 説明 |
|----------|------|------|
| id | bigint | 主キー |
| name | varchar(255) | テンプレート名 |
| image_path | varchar(255) | テンプレート画像のパス |
| paper_size | varchar(20) | 用紙サイズ (デフォルト: B5) |
| orientation | varchar(20) | 用紙の向き (portrait/landscape) |
| layout_config | json | レイアウト設定 |
| created_at | timestamp | 作成日時 |
| updated_at | timestamp | 更新日時 |

### races テーブル（既存）への追加
| カラム名 | 型 | 説明 |
|----------|------|------|
| certificate_template_id | bigint | 使用する記録証テンプレートのID |

## レイアウト設定のJSON構造

```json
{
    "elements": {
        "bib_number": {
            "x": 100,
            "y": 150,
            "font_size": 24,
            "font_family": "Gothic",
            "color": "#000000"
        },
        "category_name": {
            "x": 200,
            "y": 200,
            "font_size": 20,
            "font_family": "Gothic",
            "color": "#000000"
        },
        "participant_name": {
            "x": 300,
            "y": 250,
            "font_size": 28,
            "font_family": "Gothic",
            "color": "#000000"
        },
        "finish_time": {
            "x": 400,
            "y": 300,
            "font_size": 24,
            "font_family": "Gothic",
            "color": "#000000"
        },
        "overall_rank": {
            "x": 500,
            "y": 350,
            "font_size": 20,
            "font_family": "Gothic",
            "color": "#000000"
        },
        "category_rank": {
            "x": 600,
            "y": 400,
            "font_size": 20,
            "font_family": "Gothic",
            "color": "#000000"
        }
    }
}
```

## リレーション
- `races.certificate_template_id` → `certificate_templates.id` (外部キー)

## マイグレーション
1. certificate_templatesテーブルの作成
2. racesテーブルへのcertificate_template_idカラムの追加
3. 既存のテンプレート画像の移行
4. レイアウト設定の初期データ作成 