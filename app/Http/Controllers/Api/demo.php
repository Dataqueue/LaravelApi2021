<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class demo extends Controller
{
    //
    public function index()
    {
        // $expenses = Expense::where("status", "new")->orderBy('created_at', 'DESC')->get();
        // $expenses->map(function ($expense) {
        //     return $expense->payment_account;
        // });
        return response()->json("dsffffff");
    }
}
