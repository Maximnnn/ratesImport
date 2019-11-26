git pull git@github.com:Maximnnn/tet.git

cp .env.example .env

docker-compose build -d

docker exec -it app-tettest bash
php composer install 
php artisan migrate
php artisan import:rates



//npm install && npm run watch
