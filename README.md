![Laravel Wallet](https://github.com/bavix/laravel-wallet/assets/5111255/95e7877c-a950-4b04-9414-de62216d31c2)


[![Latest Version on Packagist](https://img.shields.io/packagist/v/koverae/koverae-billing.svg?style=flat-square)](https://packagist.org/packages/koverae/koverae-billing)
[![Total Downloads](https://img.shields.io/packagist/dt/koverae/koverae-billing.svg?style=flat-square)](https://packagist.org/packages/koverae/koverae-billing)
![GitHub Actions](https://github.com/koverae/koverae-billing/actions/workflows/main.yml/badge.svg)

[![Sparkline](https://stars.medv.io/bavix/laravel-wallet.svg)](https://stars.medv.io/bavix/laravel-wallet)

Koverae Billing - Manage plans, trials, and payments with clean, extensible logic.

[[Documentation](https://devs.koverae.com/koverae-billing/)] 
[[Get Started](https://devs.koverae.com/koverae-billing/guide/introduction/)] 

* **Vendor**: koverae
* **Package**: koverae-billing
* **[Composer](https://getcomposer.org/):** `composer require koverae/koverae-billing`

### Support Policy

| Version    | Laravel        | PHP             | Release date | End of improvements | End of support |
|------------|----------------|-----------------|--------------|---------------------|----------------|
| 11.x [LTS] | ^11.0, ^12.0   | 8.2,8.3,8.4     | Mar 14, 2024 | May 1, 2026         | Sep 6, 2026    |

### Upgrade Guide

To perform the migration, you will be [helped by the instruction](https://devs.koverae.com/koverae-billing/#/upgrade-guide).

### Community

I want to create a cozy place for developers using the Koverae Billing package. This will help you find bugs faster, get feedback and discuss ideas.

![telegram](https://github.com/bavix/laravel-wallet/assets/5111255/ed2b1193-c0c6-41af-83cb-0fe61ae8df21)


Telegram: [@koverae_billing](https://t.me/koverae_billing)

### Extensions

| Extension                                                 | Description                                                                |
|-----------------------------------------------------------|----------------------------------------------------------------------------|
| [Swap](https://github.com/bavix/laravel-wallet-swap)      | Addition to the laravel-wallet library for quick setting of exchange rates |
| [uuid](https://github.com/bavix/laravel-wallet-uuid)      | Addition to laravel-wallet to support model uuid keys                      | 
| [Warm Up](https://github.com/bavix/laravel-wallet-warmup) | Addition to the laravel-wallet library for refresh balance wallets         | 

### Usage
Add the `HasWallet` trait and `Wallet` interface to model.
```php
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Wallet;

class User extends Model implements Wallet
{
    use HasWallet;
}
```

Now we make transactions.

```php
$user = User::first();
$user->balanceInt; // 0

$user->deposit(10);
$user->balance; // 10
$user->balanceInt; // int(10)

$user->withdraw(1);
$user->balance; // 9

$user->forceWithdraw(200, ['description' => 'payment of taxes']);
$user->balance; // -191
```

### Purchases

Add the `CanPay` trait and `Customer` interface to your `User` model.
```php
use Bavix\Wallet\Traits\CanPay;
use Bavix\Wallet\Interfaces\Customer;

class User extends Model implements Customer
{
    use CanPay;
}
```

Add the `HasWallet` trait and interface to `Item` model.

Starting from version 9.x there are two product interfaces:
- For an unlimited number of products (`ProductInterface`);
- For a limited number of products (`ProductLimitedInterface`);

An example with an unlimited number of products:
```php
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Customer;
use Bavix\Wallet\Interfaces\ProductInterface;

class Item extends Model implements ProductInterface
{
    use HasWallet;

    public function getAmountProduct(Customer $customer): int|string
    {
        return 100;
    }

    public function getMetaProduct(): ?array
    {
        return [
            'title' => $this->title, 
            'description' => 'Purchase of Product #' . $this->id,
        ];
    }
}
```

Example with a limited number of products:
```php
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Interfaces\Customer;
use Bavix\Wallet\Interfaces\ProductLimitedInterface;

class Item extends Model implements ProductLimitedInterface
{
    use HasWallet;

    public function canBuy(Customer $customer, int $quantity = 1, bool $force = false): bool
    {
        /**
         * This is where you implement the constraint logic. 
         * 
         * If the service can be purchased once, then
         *  return !$customer->paid($this);
         */
        return true; 
    }
    
    public function getAmountProduct(Customer $customer): int|string
    {
        return 100;
    }

    public function getMetaProduct(): ?array
    {
        return [
            'title' => $this->title, 
            'description' => 'Purchase of Product #' . $this->id,
        ];
    }
}
```

I do not recommend using the limited interface when working with a shopping cart. 
If you are working with a shopping cart, then you should override the `PurchaseServiceInterface` interface. 
With it, you can check the availability of all products with one request, there will be no N-queries in the database.

Proceed to purchase.

```php
$user = User::first();
$user->balance; // 100

$item = Item::first();
$user->pay($item); // If you do not have enough money, throw an exception
var_dump($user->balance); // 0

if ($user->safePay($item)) {
  // try to buy again
}

var_dump((bool)$user->paid($item)); // bool(true)

var_dump($user->refund($item)); // bool(true)
var_dump((bool)$user->paid($item)); // bool(false)
```

### Eager Loading

```php
// When working with one wallet
User::with('wallet');

// When using the multi-wallet functionality
User::with('wallets');
```

### How to work with fractional numbers?
Add the `HasWalletFloat` trait and `WalletFloat` interface to model.
```php
use Bavix\Wallet\Traits\HasWalletFloat;
use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Interfaces\Wallet;

class User extends Model implements Wallet, WalletFloat
{
    use HasWalletFloat;
}
```

Now we make transactions.

```php
$user = User::first();
$user->balance; // 100
$user->balanceFloat; // 1.00

$user->depositFloat(1.37);
$user->balance; // 237
$user->balanceFloat; // 2.37
```

Table generated using [benchmark](https://github.com/Koverae/koverae-billing-benchmark/). [Pull Request](https://github.com/Koverae/koverae-billing-benchmark/pull/51).

## Contributors

### Code Contributors

This project exists thanks to all the people who contribute. [[Contribute](CONTRIBUTING.md)].

-   [Arden BOUET](https://github.com/arden28)
-   [All Contributors](../../contributors)


## License

Forked originally from [bpuig/laravel-subby](https://github.com/bpuig/laravel-subby). Thank you for
creating the original! :)

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

&copy; 2025 | Arden BOUET, Some rights reserved.
