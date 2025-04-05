# Installation

<!-- @include: ../../_include/composer.md -->

## Composer
To install Koverae Billing, open your terminal and navigate to your Laravel application directory, then run the following command:

```bash
composer require koverae/koverae-billing
```
After installing the package, you will need to publish the migrations and config:

```bash
php artisan billing:install
```

That's it — really. If you want more customization options, keep reading. Otherwise, you can jump right into using Koverae Billing.


After installing the package, you can proceed to [use it](basic-usage) or [configure](configuration) it to suit your needs.
