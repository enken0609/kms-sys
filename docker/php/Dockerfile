FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    libzip-dev

# Remove existing GD extension if it exists
RUN if [ -f /usr/local/etc/php/conf.d/*gd.ini ]; then \
    rm -f /usr/local/etc/php/conf.d/*gd.ini; \
    fi
RUN if [ -f /usr/local/lib/php/extensions/*/*gd.so ]; then \
    rm -f /usr/local/lib/php/extensions/*/*gd.so; \
    fi

# Install GD extension
RUN docker-php-ext-configure gd \
        --enable-gd \
        --with-jpeg \
        --with-freetype \
    && docker-php-ext-install -j$(nproc) gd

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    zip \
    exif

# Install and enable Imagick
RUN set -e; \
    apt-get update; \
    apt-get install -y libmagickwand-dev; \
    pecl channel-update pecl.php.net; \
    printf "\n" | pecl install imagick; \
    docker-php-ext-enable imagick; \
    rm -rf /var/lib/apt/lists/*

# Node.jsのインストール
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# PHP設定
RUN echo "memory_limit = 512M" > /usr/local/etc/php/conf.d/memory-limit.ini \
    && echo "upload_max_filesize = 10M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 10M" >> /usr/local/etc/php/conf.d/uploads.ini

# Composerのインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 作業ディレクトリの設定
WORKDIR /var/www

# ユーザー設定
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# アプリケーションのコピー
COPY . /var/www
COPY --chown=www:www . /var/www

# パーミッションの設定
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# 依存関係のインストール
RUN npm install 