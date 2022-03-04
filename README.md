# setup project
## env
```
cp .env.example .env;
composer install;
php artisan migrate:refresh; php artisan passport:install; 
copy Client secret to .env file
```
## nginx
```
copy file ./nginx.conf 
to laradock at
path: nginx/sites/codeby-be.conf
```
## postman
```
MAIN.postman_collection.json
```

# cache 
php artisan lighthouse:clear-cache

[//]: # (# copy)
[//]: # (cp -fR /Users/nguyenvantien/Jobs/boilerplate/laravel-graphql/* /Users/nguyenvantien/Jobs/codeby/codeby-be)
