FROM php:8.2-fpm

# Node.jsのインストール
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 必要なパッケージのインストール
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

# PHPの拡張機能をインストール
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# PHP設定のカスタマイズ - メモリ制限を増やす
RUN echo "memory_limit = 512M" > /usr/local/etc/php/conf.d/memory-limit.ini
RUN echo "upload_max_filesize = 10M" > /usr/local/etc/php/conf.d/uploads.ini
RUN echo "post_max_size = 10M" >> /usr/local/etc/php/conf.d/uploads.ini

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# アプリケーションディレクトリを作成
WORKDIR /var/www

# ユーザー権限の設定
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# アプリケーションファイルのコピー
COPY . /var/www
COPY --chown=www:www . /var/www

# ストレージとキャッシュディレクトリに書き込み権限を付与
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# npmパッケージのインストール
RUN npm install

# 実行ユーザーの変更
USER www

# Composerの依存関係をインストール
# RUN composer install
# ビルド時に問題が発生するため、コンテナ起動後に手動で実行

# アプリケーションポートの公開
EXPOSE 9000

# PHPFPMの起動
CMD ["php-fpm"] 