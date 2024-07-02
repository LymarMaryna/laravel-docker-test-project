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

Copy the `src/.env.example` file to `src/.env` and update the environment variables as necessary:

   ```bash
   cp src/.env.example src/.env
   ```

Make sure your `src/.env` file contains the following PostgreSQL configurations:
 ```plaintext
DB_CONNECTION = pgsql
DB_HOST = db_postgres
DB_PORT = 5432
DB_DATABASE = postgres
DB_USERNAME = postgres
DB_PASSWORD = postgres
````

Add into `src/.env` file credentials from [CoinGecko API](https://www.coingecko.com/en/api/documentation) and JWT secret key

 ```plaintext
COIN_API_URL = https://api.coingecko.com/api/v3/coins/markets
COIN_API_KEY = your_api_key_here
JWT_SECRET = your_jwt_secret_here
````

#### 3. Run bash script to set up the project:

   ```bash
   bash RunMe.sh
   ```

#### 7. Access the application:

The application should now be running on http://localhost:8080

#### 8. Usage

Commands to run in the cli for parsing data from the API and saving it to the database:

   ```bash
   bash FetchData.sh
   ```
also you can call:
 ```bash
   docker-compose exec app php artisan parse:currencies
   ```

## API Routes

### Currencies

#### List Currencies

```http
  GET /api/currencies
```

#### Show Currency

```http
  GET /api/currencies/${identifier}
```

### Authentication

#### Issue JWT Token

```http
  POST /api/issue-token
```

