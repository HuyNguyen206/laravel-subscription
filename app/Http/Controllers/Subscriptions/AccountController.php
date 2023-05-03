<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index()
    {
        return view('subscriptions.account');
    }
}
