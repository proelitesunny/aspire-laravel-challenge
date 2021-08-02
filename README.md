## Aspire Laravel Challenge

Mini Aspire API for mobile applications:

### Application Details
The application allows to authenticate and get a loan of max 50,000 (Configuration in config files) and a maximum tenure of 104 weeks (Configurable).

The application contains total of 8 APIs.
1.  Register
2.  Login
3.  Logout
4.  Loan Enquiry: To get of loan and interest details.
5.  Create Loan: To get a Loan
6.  Loan Detail: Get the loan and transaction details of a particular loan.
7.  My Loans: Get a list all of a user loans.
8.  Loan Pay: Make a payment for a loan.

> In the login and register API, you will get a token. That token needs to pass in the header as a Bearer Token for authenticating other APIs.

> A POSTMAN collection is included in the repository in the root folder for accessing all the APIs.

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
- Update the details and credentials for Test Cases Purpose.
- Edit **phpunit.xml** file and set the DB connection and database details for testing purpose.
- Generate a new application key<br>
    `php artisan key:generate`
- Copy the key in **.env.testing** file<br>
- Run database migrations<br>
     `php artisan migrate`
- Start the local development server<br>
     `php artisan serve`
- You can now access the server at http://localhost:8000
- Run the Tests<br>
     `./vendor/bin/phpunit`
