composer install

if [ ! -f ./.env ]; then
    cp .env.example .env
    php artisan key:generate
fi

php artisan storage:link
php artisan migrate
php artisan db:seed

service php7.2-fpm start
cron
nginx
