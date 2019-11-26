need docker, npm

sudo service apache2 stop

sudo /etc/init.d/mysql stop


Installatioin:

git pull git@github.com:Maximnnn/tet.git

cp .env.example .env

docker-compose up -d --no-deps --build

docker exec -it app-tettest bash

composer install 

php artisan migrate

php artisan import:rates

php artisan key:generate
