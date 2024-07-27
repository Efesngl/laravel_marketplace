<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function specs($category_id){
        $category = Category::with("specifications:specification,id","specifications.values:value,id,specification_id")->find($category_id);
        return response()->json($category);
    }
}
