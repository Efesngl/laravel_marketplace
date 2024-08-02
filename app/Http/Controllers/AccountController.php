<?php

namespace App\Http\Controllers;

use App\Models\Deal;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AccountController extends Controller
{
    //
    public function index()
    {
        return Inertia::render("Account/AccountDetails");
    }
    public function deals(Request $request,String $status){
        if($status!="active" && $status!="inactive"){
            abort(404);
        }
        $deals=User::find($request->user()->id)->deals()->where("is_active","=",($status=="active")?true:false)->get();
        return Inertia::render("Account/MyDeals",[
            "deals"=>$deals
        ]);
    }
    public function updateProfile(Request $request)
    {
        $profile = $request->validate([
            "name" => ["required"],
            "birthDate" => ["required", "date"],
            "gender" => ["required"],
        ]);
        $user = User::find($request->user()->id);
        $user->name = $profile["name"];
        $user->gender = $profile["gender"];
        $user->birth_date = $profile["birthDate"];
        $user->save();
        return response("", 200);
    }

    public function updateEmail(Request $request)
    {
        $email = $request->validate([
            "email" => ["required", "email", Rule::unique("users")->ignore($request->user()->id)],
        ]);
        $user = User::find($request->user()->id);
        if ($user->email != $email["email"]) {
            $user->email = $email["email"];
            $user->save();
        }
        return response("", 200);
    }
    public function updatePhone(Request $request)
    {
        $pn = $request->validate([
            "phoneNumber" => ["required","size:10", Rule::unique("users","phone_number")->ignore($request->user()->id)],
        ]);
        $user = User::find($request->user()->id);
        if ($user->phone_number != $pn["phoneNumber"]) {
            $user->phone_number = $pn["phoneNumber"];
            $user->save();
        }
        return response("", 200);
    }

    public function updatePassword(Request $request)
    {
        $password= $request->validate([
            "oldPassword"=>["required"],
            "newPassword"=>["required","confirmed"]
        ]);
        $user=User::find($request->user()->id);
        if(!Hash::check($password["oldPassword"],$user->password)){
            return back()->withErrors(["oldPassword"=> "Incorrect Password !"]);
        }
        $user->password= $password["newPassword"];
        $user->save();
        return response("",200);
    }


}
