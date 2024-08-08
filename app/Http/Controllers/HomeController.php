<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    //
    public function index(){
        $deals=Deal::where("is_active","=",true)->when(!is_null(auth()->user()),function(Builder $builder){
            $builder->whereNot("user_id","=",auth()->user()->id);
        })->get();
        return Inertia::render("Home",[
            "deals"=>$deals
        ]);
    }
}
