

## Installation

- Download the project
- Import crud.sql
- Rename the .env.example file to .env
- Add database details in .env file
- run composer install
- run php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
- Generate secret key by running php artisan jwt:secret
