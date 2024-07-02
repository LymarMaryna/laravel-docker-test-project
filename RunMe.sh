# Install composer dependencies
cd ./src
composer install
cd ../

# Build docker containers
docker-compose up -d --build

# Iitialize laravel project and migrate database
sleep 5
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate