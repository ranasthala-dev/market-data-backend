## Market Data

By tracking daily trades, we can spot emerging trends and capitalize on short-term price movements. This can be particularly useful for day traders and swing traders.

## Prerequisites

Before you begin, ensure you have the following installed:

* PHP: Version 8.1 or higher is recommended. Check your PHP version with `php -v`.
* Composer: A dependency manager for PHP.  Download and install it from [https://getcomposer.org/](https://getcomposer.org/).
* Database: MySQL.

## Installation

1. ```git clone https://github.com/ranasthala-dev/market-data-backend.git```, 
2. ```cd market-data-backend```
2. composer install
3. cp .env.example .env  (configure database credentials)
4. php artisan key:generate
5. php artisan migrate
6. php artisan serve
