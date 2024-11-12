<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    public function add($a, $b)
    {
        $result = $a + $b;
        return response()->json(['result' => $result]);
    }
}
