cd /var/www/gift-shop-diplom/
php artisan down  
php artisan migrate --force  
git checkout master  
git reset --hard HEAD  
git clean -f -d  
git pull  
composer u  
chmod -R ug+rwx storage bootstrap/cache  
chgrp -R nginx storage bootstrap/cache  
yarn  
yarn prod  
php artisan config:cache  
php artisan route:cache  
php artisan view:clear  
php artisan up  