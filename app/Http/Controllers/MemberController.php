<?php

namespace App\Http\Controllers;

use App\Http\Middleware\OnlyMemberCanAccess;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware(OnlyMemberCanAccess::class);
    }

    public function index()
    {
        return view('member.index');
    }
}
