## Aspire Laravel Challenge

Mini Aspire API for mobile applications:

### Setting up the Projects

- Clone the Repository.
- Switch to Repo folder
    `cd aspire-laravel-challenge`
- Install the requred dependencies
     `composer install`
- Copy the example env file
    <br>`cp .env.example .env`
    <br>`cp .env.example .env.testing`
- Edit the followings in .env file
  - **APP_NAME** - Example(APP_NAME="Aspire Laravel Challenge")
  - **APP_ENV** - Example(APP_ENV=local)
  - **APP_URL** - Example(APP_URL=https://localhost:8000)
  - **DB_DATABASE** - Example(DB_DATABASE=aspire) - Create a blank database and use the same database name here.
  - **DB_USERNAME** - Example(DB_USERNAME=root)
  - **DB_PASSWORD** - Your MySQL Password
- Edit the followings in .env.testing file
    - **APP_NAME** - Example(APP_NAME="Aspire Laravel Challenge")
    - **APP_ENV** - Example(APP_ENV=testing)
    - **APP_URL** - Example(APP_URL=https://localhost:8000)
    - **DB_DATABASE** - Example(DB_DATABASE=aspire) - Create a blank database and use the same database name here.
    - **DB_USERNAME** - Example(DB_USERNAME=root)
    - **DB_PASSWORD** - Your MySQL Password
- Generate a new application key
    `php artisan key:generate`
- Run database migrations
     `php artisan migrate`
- Start the local development server
     `php artisan serve`
- You can now access the server at http://localhost:8000
