<?php

namespace App\Presenter;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use Stripe\Invoice;

class StripeInvoice
{
    public function __construct(protected Invoice $model)
    {
    }

    public function amount()
    {
        $formatter = new IntlMoneyFormatter(
            new \NumberFormatter(config('cashier.currency_locale'), \NumberFormatter::CURRENCY),
            new ISOCurrencies()
        );

        $money = new Money(
            $this->model->amount_due,
            new Currency(Str::upper(config('cashier.currency')))
        );

        return $formatter->format($money);
    }

    public function nextPaymentAttemp()
    {
        return (new Carbon($this->model->next_payment_attempt))->toFormattedDateString();
    }
}
