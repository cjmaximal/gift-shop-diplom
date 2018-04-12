cd /var/www/gift-shop-diplom/
php artisan down  
php artisan migrate --force  
git checkout master  
git reset --hard HEAD  
git clean -f -d  
git pull  
composer u  
yarn  
yarn prod  
php artisan config:clear  
php artisan route:clear  
php artisan view:clear  
php artisan up  