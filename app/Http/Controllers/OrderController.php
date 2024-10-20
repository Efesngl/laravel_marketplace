<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    //
    public function index(){
        $orders=auth()->user()->orders;
        return Inertia::render("Account/Orders",[
            "orders"=>$orders
        ]);
    }
}
