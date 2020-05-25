<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreKeys;

class UserKeysController extends Controller
{
    public function update(StoreKeys $request)
    {
        $validated = $request->validated();

        $user = $request->user();
        $user->public_key = $validated['public_key'];
        $user->private_key = $validated['private_key'];
        $user->save();
        
        return $validated;
    }
}
