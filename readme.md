# LaraStore.
Conceptual prototype for managing multiple stores from centralized location.

#### Important
Prior `php artisan db:seed` make sure you have created following variables in `.env` file:

`STORE_1_CK=<WooCommerce Consumer Key>`
`STORE_1_CS=<WooCommerce Consumer Secret>`

`STORE_2_USERNAME=<Magento API Username>`
`STORE_2_PASSWORD=<Magento API Password>`

#### Installation
* `php composer.phar install`,
* `php artisan key:generate`,
* `php artisan migrate`,
* `php artisan db:seed`.