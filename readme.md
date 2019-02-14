# LaraStore.
Conceptual prototype for managing multiple stores (WooCommerce and Magento) from centralized location.

#### Important
Prior `php artisan db:seed` make sure you have created following variables in `.env` file:

* `STORE_1_CK` (WooCommerce API consumer key)
* `STORE_1_CS` (WooCommerce API consumer secret)
* `STORE_2_USERNAME` (Magento API username)
* `STORE_2_PASSWORD` (Magento API password)

#### Installation
* `php composer.phar install`,
* `php artisan key:generate`,
* `php artisan migrate`,
* `php artisan db:seed`.