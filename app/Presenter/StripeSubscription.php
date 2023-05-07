<?php

namespace App\Presenter;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Stripe\Subscription;

class StripeSubscription
{
    public function __construct(protected Subscription $model)
    {
    }

    public function interval()
    {
        return $this->model->plan->interval;
    }

    public function amount()
    {
        $formatter = new IntlMoneyFormatter(
            new \NumberFormatter(config('cashier.currency_locale'), \NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        $money = new Money(
            $this->model->plan->amount,
            new Currency(Str::upper(config('cashier.currency')))
        );

        return $formatter->format($money);
    }

    public function cancelAt()
    {
        return Carbon::createFromTimestamp($this->model->cancel_at)->toFormattedDateString();
    }

    public function coupon()
    {
        if (!$discount = $this->model->discount){
            return;
        }

        return new StripeCoupon($discount->coupon);
    }

}
