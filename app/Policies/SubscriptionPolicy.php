<?php

namespace App\Policies;

use App\Models\User;

class SubscriptionPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function resumeSubscription(User $user)
    {
        return $user->subscription()->canceled();
    }

    public function cancelSubscription(User $user)
    {
        return !$user->subscription()->canceled();
    }
}
