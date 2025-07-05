# Insurance Quotation API - Coding Challenge

This repository contains the backend and frontend solution for a full-stack coding challenge. The application provides a RESTful API to calculate insurance policy quotations based on age, trip duration, and currency. It is built using Laravel 12 and follows modern architectural best practices.

# Project Overview
The core feature is a quotation calculation engine exposed via a secure API endpoint. The project includes:

- A RESTful API built with Laravel 12.

- JWT-based authentication to secure the API.

- A robust backend architecture using the Action-Service-Repository pattern.

- A database seeder to create a default user for testing.

- A comprehensive test suite using Pest.

- A simple Blade-based frontend with a login form and a quotation form to demonstrate a real-world API consumption flow.

# Technologies & Tools

- Backend: Laravel 12, PHP 8.2+

- Authentication: tymon/jwt-auth for JSON Web Tokens.

- Database: MySQL (or your preferred SQL database).

- Testing: Pest for feature and unit tests.


# Using a Local Environment (Herd/Valet)

Clone the Repository

``git clone https://github.com/amuvavi/coding-challenge.git``
``cd coding-challenge``

Install PHP Dependencies

``composer install``

Prepare Environment File

``cp .env.example .env``

Open the ``.env`` file and configure your DB_* variables to match your local database credentials.

Generate Application Key

``php artisan key:generate``

Run Migrations and Seed the Database

``php artisan migrate:fresh --seed --seeder=TestUserSeeder``

Access the Application

The frontend form is available at the URL configured by Herd/Valet (e.g., http://coding-challenge.test).

The API endpoints are available under: http://your-local-domain.test/api/

Database Seeding
A dedicated seeder is included to create a consistent user for testing.

Test User Credentials:

``Email: tester@example.com``

``Password: password``

To run the seeder manually at any time, use the following command:

# For Local Environment
``php artisan db:seed --class=TestUserSeeder``

Running Tests
The project includes a suite of feature and unit tests written with Pest to ensure the API is working correctly.

To run the entire test suite, execute the following command from the project root:

# For Local Environment
``php artisan test``

The tests cover authentication, validation rules, successful quotation generation, and the core calculation logic.

API Usage Guide (Postman)
To test the API manually, you must follow the two-step authentication flow.

Step 1: Get an Authentication Token
First, make a request to the login endpoint to get a JWT.

Method: POST

URL: http://localhost/api/login

Headers:

``Content-Type: application/json``

``Accept: application/json``

Body (raw, JSON):
``
{
    "email": "tester@example.com",
    "password": "password"
}
``
The response will contain your access_token. Copy it.

Step 2: Call the Protected Quotation Endpoint
Now, use the token from the login response to make an authorized request.

Method: POST

URL: http://localhost/api/quotation

Headers:

``Content-Type: application/json``

``Accept: application/json``

Authorization: Bearer <paste_your_token_here>

Body (raw, JSON):
```
{
    "age": "28,35",
    "currency_id": "EUR",
    "start_date": "2025-10-01",
    "end_date": "2025-10-30"
}
```
A successful request will return a 200 OK status with the calculated quotation details.

Project Architecture
The backend is structured using the Action-Service-Repository pattern to ensure a clean separation of concerns:

Controllers: Handle HTTP-level concerns.

Form Requests: Handle validation and authorization.

Actions: Orchestrate single business logic tasks.

Services: Contain reusable, core business logic (e.g., the calculation engine).

Repositories: Abstract the database layer.

API Resources: Transform Eloquent models into consistent JSON responses.