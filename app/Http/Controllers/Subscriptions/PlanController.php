<?php

namespace App\Http\Controllers\Subscriptions;

use App\Http\Controllers\Controller;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('subscriptions.plans', compact('plans'));
    }
}
