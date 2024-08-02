<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    //
    public function index(){
        $deals=Deal::where("is_active","=",true)->get();
        return Inertia::render("Home",[
            "deals"=>$deals
        ]);
    }
}
