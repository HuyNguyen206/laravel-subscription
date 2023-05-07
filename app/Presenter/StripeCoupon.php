<?php

namespace App\Presenter;

use Illuminate\Support\Str;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Stripe\Coupon;

class StripeCoupon
{
    public function __construct(protected Coupon $model)
    {
    }

    public function name()
    {
        return $this->model->name;
    }

    public function value()
    {
        return $this->model->percent_off ? $this->model->percent_off.'%' : $this->amount();
    }

    public function amount()
    {
        $formatter = new IntlMoneyFormatter(
            new \NumberFormatter(config('cashier.currency_locale'), \NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        $money = new Money(
            $this->model->amount_off,
            new Currency(Str::upper(config('cashier.currency')))
        );

        return $formatter->format($money);
    }

}
