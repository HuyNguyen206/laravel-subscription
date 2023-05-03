<?php

namespace App\Policies;

use App\Models\User;
use Laravel\Cashier\Subscription;

class SubscriptionPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function resumeSubscription(User $user, Subscription $subscription)
    {
        return $subscription->canceled();
    }

    public function cancelSubscription(User $user, Subscription $subscription)
    {
        return !$subscription->canceled();
    }
}
