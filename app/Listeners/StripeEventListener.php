<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Support\Arr;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        $payload = $event->payload;
        if ($payload['type'] === 'payment_intent.succeeded') {
            $userId = Arr::get($payload, 'data.object.charges.data.0.metadata.user_id');
            session()->forget("users.$userId.payment_intent");
            info($userId);
            if ($userId) {
                info('test');
                User::whereId((int) $userId)->update([
                    'is_lifetime' => true
                ]);
            }
            session()->save();
        }
    }
}
