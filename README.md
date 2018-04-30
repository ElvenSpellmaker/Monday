Monday Guest User Bulk Add
==========================

Adding guest users to boards on Monday.com isn't easy as each e-mail must be
entered manually.
This script (until their site changes) allows you to supply an e-mail list and
this will invite all the e-mails to the chosen board as guests.

Tested with PHP 7.1.

Notes:
  - The `userlist` file should be e-mails separated by newlines.
  - The `userlist` file should contain UNIX line endings `\n`, else the script
    might not work!

Usage
-----

1. Copy `config.php` to `config.local.php` and then add your company name,
the board id you want to add the users to, and the cookie of a logged-in admin
user.
2. Run `php monday-add-guests.php` and enjoy.
