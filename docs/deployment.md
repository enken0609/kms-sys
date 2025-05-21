# Xserverへのデプロイ手順

## 1. 事前準備

### 1.1 ローカル環境での準備
1. 本番用の`.env`ファイルを作成
```bash
cp .env .env.production
```

2. 本番用の`.env`ファイルを編集
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
FILESYSTEM_DISK=uploads

DB_HOST=mysql***.xserver.jp
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 1.2 本番用にビルド
```bash
# アセットのビルド
npm run build

# composerの最適化
composer install --optimize-autoloader --no-dev
```

## 2. ファイルのアップロード

### 2.1 必要なファイル/ディレクトリ
以下のファイル/ディレクトリをアップロード:
```
app/
bootstrap/
config/
database/
lang/
public/
resources/
routes/
storage/
vendor/
.env.production（.envとしてアップロード）
artisan
composer.json
composer.lock
```

### 2.2 パーミッション設定
```bash
# ストレージディレクトリ
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# アップロードディレクトリ
mkdir -p public_html/uploads/certificate-templates
chmod 755 public_html/uploads
chmod 777 public_html/uploads/certificate-templates
```

## 3. データベースのセットアップ

### 3.1 マイグレーションの実行
```bash
# Xserverのコンソールで
cd ~/your_project_directory
php artisan migrate --force
```

### 3.2 キャッシュテーブルの作成（必要な場合）
```bash
php artisan cache:table
php artisan migrate --force
```

## 4. Laravel の最適化

### 4.1 設定のキャッシュ
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4.2 オートローダーの最適化
```bash
composer dump-autoload -o
```

## 5. フォント設定

### 5.1 フォントファイルの配置
1. `resources/fonts` ディレクトリを作成
2. 必要なフォントファイルを配置:
   - NotoSansJP-Regular.ttf
   - NotoSansJP-Bold.ttf

### 5.2 dompdfの設定
`config/dompdf.php`の設定を確認:
```php
return [
    'font_dir' => base_path('resources/fonts/'),
    'font_cache' => storage_path('fonts/'),
    'temp_dir' => sys_get_temp_dir(),
];
```

## 6. Xserverの設定

### 6.1 PHPのバージョン設定
- PHPバージョンを8.2以上に設定

### 6.2 PHPの設定値
以下の値を設定（Xserverの管理画面から）:
- memory_limit: 256M以上
- max_execution_time: 120以上
- upload_max_filesize: 10M以上
- post_max_size: 10M以上

### 6.3 SSLの設定
- 管理画面からSSL証明書を発行/設定
- HTTPSでのアクセスを強制

## 7. 動作確認

### 7.1 確認項目
1. トップページの表示
2. 管理画面へのログイン
3. 記録証テンプレートのアップロード
4. PDFの生成とダウンロード

### 7.2 エラー発生時の確認
1. ストレージのログを確認
```bash
tail -f storage/logs/laravel.log
```

2. PHPのエラーログを確認
```bash
tail -f /home/your-account/logs/php.log
```

## 8. セキュリティ設定

### 8.1 重要ディレクトリの保護
以下のディレクトリに.htaccessを設置:
```apache
# storage/, bootstrap/の.htaccess
Order deny,allow
Deny from all
```

### 8.2 本番環境での設定確認
- APP_DEBUG=false
- APP_ENV=production
- デバッグモードが無効化されていること
- エラーページが適切に表示されること

## 9. バックアップ設定

### 9.1 定期バックアップの設定
- データベースの定期バックアップ
- アップロードされたファイルの定期バックアップ
- Xserverの自動バックアップ機能の有効化

### 9.2 バックアップの保存先
- ローカルストレージ
- 外部ストレージ（推奨）

## 10. トラブルシューティング

### 10.1 よくある問題と解決方法
1. 500エラー
   - ストレージのパーミッション確認
   - ログファイルの確認
   - .envファイルの設定確認

2. 画像アップロードエラー
   - uploadsディレクトリのパーミッション確認
   - PHPの設定値確認
   - ディスク容量の確認

3. PDF生成エラー
   - メモリ制限の確認
   - フォントファイルの配置確認
   - tempディレクトリの書き込み権限確認

### 10.2 パフォーマンスの最適化
1. OPcacheの設定
2. Composerのオートローダー最適化
3. キャッシュの活用

## 11. メンテナンス

### 11.1 定期的な確認事項
- ログファイルのローテーション
- ディスク使用量の監視
- セキュリティアップデートの適用
- Laravel/PHPのバージョンアップデート

### 11.2 メンテナンスモード
```bash
# メンテナンスモードの有効化
php artisan down

# メンテナンスモードの解除
php artisan up
``` 