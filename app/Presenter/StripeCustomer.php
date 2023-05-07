<?php

namespace App\Presenter;

use Illuminate\Support\Str;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Stripe\Customer;

class StripeCustomer
{
    public function __construct(protected Customer $model)
    {
    }

    public function amount()
    {
        $formatter = new IntlMoneyFormatter(
            new \NumberFormatter(config('cashier.currency_locale'), \NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        $money = new Money(
            $this->model->balance,
            new Currency(Str::upper(config('cashier.currency')))
        );

        return $formatter->format($money);
    }
}
