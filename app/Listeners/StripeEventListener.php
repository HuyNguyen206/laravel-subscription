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
//            $payload['data']['object']["charges"]['data']["metadata"]['user_id'] ?? null
        $payload = $event->payload;
        if ($payload['type'] === 'payment_intent.succeeded') {
            $userId = Arr::get($payload, 'data.object.charges.data.0.metadata.user_id');
            info($userId);
            if ($userId) {
                info('test');
                User::whereId((int) $userId)->update([
                    'is_lifetime' => true
                ]);
            }
        }
    }
}
