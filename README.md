# docker-compose laravel + postgres

### This project is a Laravel application configured to run with a PostgreSQL database using Docker.
### Follow the instructions below to set up and run the project.

## Installation

Ensure you have the following software installed:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Git](https://git-scm.com/downloads)
- [Composer](https://getcomposer.org/download/)

#### 1. Clone the repository:

   ```bash
   git clone https://github.com/LymarMaryna/laravel-docker-test-project.git
   cd laravel-docker-test-project
   ```
   
#### 2. Create an environment file. 

Copy the `.env.example` file to `.env`:

   ```bash
   cp .env.example .env
   ```

   Make sure your .env file contains the following PostgreSQL configurations:
   ```bash
POSTGRES_DB=yourdatabase
POSTGRES_USER=yourusername
POSTGRES_PASSWORD=yourpassword
```

Copy the `src/.env.example` file to `src/.env` and update the environment variables as necessary:

   ```bash
   cp src/.env.example src/.env
   ```

Make sure your `src/.env` file contains the following PostgreSQL configurations:
 ```bash
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=yourdatabase
DB_USERNAME=yourusername
DB_PASSWORD=yourpassword
````

Make sure your `src/.env` file contains the additional configurations:
 ```bash
COIN_API_URL='https://api.coingecko.com/api/v3/coins/markets'
COIN_API_KEY='your_api_key_here'
JWT_SECRET='your_jwt_secret_here'
````



#### 3. Build the Docker containers:

   ```bash
   docker-compose up -d --build
   ```

#### 4. Install the Composer dependencies:

Access the <b>app</b> container and install the necessary dependencies using Composer.

   ```bash
   composer install
   ```

#### 5. Generate the Laravel application

 ```bash
   docker-compose exec app php artisan key:generate
   ```

#### 6. Run database migrations:

 ```bash
   docker-compose exec app php artisan migrate
   ```

#### 7. Access the application:

The application should now be running on `http://localhost`

#### 8. Usage

Commands to run in the cli for parsing data from the API and saving it to the database:

 ```bash
   docker-compose exec app php artisan parse:currencies

   ```

