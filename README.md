
# SmartFastPay Payment Processing API

This API is developed to handle payment processing for the SmartFastPay platform. It supports various payment methods and ensures secure and efficient transactions. The API is built using Flask, a lightweight Python framework, and connects to a robust database system to manage payment records.

## Technologies Used

- **Laravel**: A PHP framework for building robust web applications and APIs.
- **MySql**: A robust database system for managing payment records.

## Prerequisites

Before deploying this project, ensure you have the following installed:

- **PHP**: Version 8.0 or higher. You can download it from [php.net](https://www.php.net/downloads).
- **Composer**: The latest version. You can download it from [getcomposer.org](https://getcomposer.org/).
- **Docker**: Ensure Docker is installed and running. You can download it from [docker.com](https://www.docker.com/get-started).
- **Docker Compose**: Ensure Docker Compose is installed. It usually comes with Docker Desktop, but you can also download it from [docker.com](https://docs.docker.com/compose/install/).

To verify the installations, you can run the following commands:

```bash
php -v
composer -v
docker -v
docker-compose -v
```

## Deployment Steps

### 1. Clone the Project

Clone the project from the repository:
```bash
git clone https://github.com/jhonlpjr/api_smart_fast_pay.git
cd api_smart_fast_pay
```

### 2. Start the MySQL Container

Start the MySQL container using Docker Compose:
```bash
docker-compose up -d
```

### 3. Verify Environment Configuration

Verify and update the environment configuration in the `.env` file. By default, the following parameters are set:
```properties
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smart_fast_pay
DB_USERNAME=admin
DB_PASSWORD=123456
```
## Notas
Si desean, se puede modificar a voluntad y, si fuera el caso, modificar en el docker-compose.yml y en el archivo [.env]

### 4. Install Project Dependencies

Install the project dependencies using Composer:
```bash
composer update
```

### 5. Run Migrations and Seeders

Run the database migrations and seeders:
```bash
php artisan migrate
php artisan db:seed
```

### 6. Start the Project

Start the project using the Laravel development server:
```bash
php artisan serve
```

### 7. Access the API Endpoints

The API endpoints are now available for use.

### 8. Swagger Documentation

The API endpoints, routes, requests, and responses are documented in Swagger. If the documentation does not load, generate it using:
```bash
php artisan l5-swagger:generate
```

## Access the Swagger documentation at:
```bash
http://localhost:8000/api/documentation
```

## Default User for login in API
```bash
username: jox
password: 12345678
```

## Authors

- [@jon.snow](https://github.com/jhonlpjr)

