# Menggunakan image webdevops/php-nginx
FROM webdevops/php-nginx:8.1-alpine

# Set web root ke direktori public
ENV WEB_DOCUMENT_ROOT=/app/public/

# Set php timezone ke Asia/Jakarta
ENV PHP_DATE_TIMEZONE=Asia/Jakarta

# Set working directory ke direktori proyek Laravel
WORKDIR /app

# Copy file Laravel ke container
COPY . /app

# Install dependensi PHP menggunakan Composer
RUN composer install --optimize-autoloader --no-dev

# Generate key Laravel
RUN php artisan key:generate

# Set permission pada direktori storage dan cache
RUN chown -R www-data:www-data \
    /app/storage \
    /app/bootstrap/cache
RUN chmod -R ug+rwx \
    /app/storage \
    /app/bootstrap/cache

# Set storage link
RUN php artisan storage:link

# Menjalankan perintah Laravel untuk menjalankan migrasi
RUN php artisan migrate

# Install npm package
RUN npm install

# Build assets
RUN npm run build
