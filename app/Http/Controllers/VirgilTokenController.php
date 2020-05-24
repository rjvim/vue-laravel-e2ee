<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\JWTGenerator;

class VirgilTokenController extends Controller
{
    public function generate()
    {
        $JWTGenerator = new JWTGenerator();

        return $JWTGenerator->generate(request()->user()->email);
    }
}
