<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Presenter\StripeCustomer;
use App\Presenter\StripeInvoice;
use App\Presenter\StripeSubscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Cashier\Subscription;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_lifetime' => 'bool'
    ];

    public function plan()
    {
        return $this->hasOneThrough(Plan::class, Subscription::class, 'user_id', 'stripe_id','id', 'stripe_price');
    }

    public function getStripeSubscription()
    {
        if (!$this->subscribed()) {
            return;
        }

        return new StripeSubscription($this->subscription()->asStripeSubscription());
    }

    public function getStripeInvoice()
    {
        if (!$invoice = $this->upcomingInvoice()) {
            return;
        }

        return new StripeInvoice($invoice->asStripeInvoice());
    }

    public function getStripeCustomer()
    {
        if (!$this->hasStripeId()) {
            return;
        }

        return new StripeCustomer($this->asStripeCustomer());
    }

    public function isMember()
    {
        return $this->is_lifetime || $this->subscribed();
    }
}
