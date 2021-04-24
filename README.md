## About

Started 24/04/21 using a clone of a base project that is nothing more than a fresh Laravel install.

## Limitations

Known limitations:

- Only one user per account.
- Only one account per user (database is set up to allow multiple though)
- Ability to add deposits/withdrawals in the future disrupts the actual account balance (solution proposed below)
- No use of currencies

## Improvements

Potential improvements:

- Use a currency lookup table with user origin to provide currency options
- When adding deposits/withdrawals in the future these are instead pending transactions which get picked up and executed by a cron script on the chosen day of the transaction
- Functionality to add other accounts
- Re-usable transaction references
- Filtering on transactions
