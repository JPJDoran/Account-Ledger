## About

Started 24/04/21 using a clone of a base project that is nothing more than a fresh Laravel install.

On registration of a new user, a new account is opened with a balance of 2000.00 and an overdraft of 250.00 for the registering user. The user can then manage their account by adding deposits and/or withdrawals. If the balance surpasses 4000.00 the user is prompted to think about saving options, where as if the user enters their overdraft they are warned that they are overdrawn.

The system fufills the basic requirements of an MVP but has been laid out to be extensible in the future. For example, while there is no current manner in which a user can add a new account the infrastructure supports the one to many relationship between users and accounts. 

## Installation

Laravel was used for the creation of this project and was hosted locally on a docker container using docker desktop. As such, if needed please configure docker:

- Mac: https://laravel.com/docs/8.x/installation#getting-started-on-macos
- Windows: https://laravel.com/docs/8.x/installation#getting-started-on-windows
- Linux: https://laravel.com/docs/8.x/installation#getting-started-on-linux

With docker installed we can now progress to installing the project.

1. Clone this repo to your local environment.
    1. If you're using windows you'll need to ensure you clone it to your WSL2 operating system to use docker desktop (see above).
2. `cd` into the project.
3. Open a new command line tab in this folder and run `./vendor/bin/sail up` to launch the project
4. Install composer dependencies with `composer install`
5. Install npm dependencies with `npm install`
6. Build js/css with `npm run dev`
7. Copy example env file `cp .env.example .env`
8. Generate an encryption key `php artisan key:generate`
9. Create a database on your local and update your .env file with the correct details
10. Migrate database tables `php artisan migrate`

## Limitations

Known limitations:

- Only one user per account
- Only one account per user
- Proposed ordering of transaction may be misleading
- No use of currencies

## Improvements

Potential improvements:

- Use a currency lookup table with user origin to provide currency options
- When adding deposits/withdrawals in the future these are instead pending transactions which get picked up and executed by a cron script on the chosen day of the transaction
- Functionality to add other accounts
- Re-usable transaction references
- Filtering on transactions
- Use laravel email notifications for when a user enters their saving target or overdraft
