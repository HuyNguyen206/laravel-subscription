<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Laravel\Cashier\Cashier;
use Stripe\Coupon as StripeCoupon;
use Stripe\Exception\InvalidRequestException;

class CouponValid implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
           $coupon = StripeCoupon::retrieve($value, [
                'api_key' => config('cashier.secret'),
                'stripe_version' => Cashier::STRIPE_VERSION,
                'api_base' => Cashier::$apiBaseUrl,
            ]);

           if (!$coupon->valid) {
               $fail('The :attribute is invalid.');
           }
        } catch (InvalidRequestException $ex) {
            $fail('The :attribute does not exist.');
        }
    }
}
