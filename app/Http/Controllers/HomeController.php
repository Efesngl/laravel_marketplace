<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    //
    public function index(){
        $deals=Deal::all();
        return Inertia::render("Home",[
            "deals"=>$deals
        ]);
    }
}
