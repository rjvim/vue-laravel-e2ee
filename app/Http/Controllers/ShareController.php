<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ShareController extends Controller
{
    public function get(Request $request)
    {
        return User::where('email', $request->email)
                ->whereNotNull('private_key')
                ->select('email', 'public_key')
                ->firstOrFail();
    }

    public function keys(Request $request)
    {
        return User::whereIn('email', $request->emails)
                ->whereNotNull('private_key')
                ->select('public_key')
                ->get()
                ->pluck('public_key')
                ->toArray();
    }
}
